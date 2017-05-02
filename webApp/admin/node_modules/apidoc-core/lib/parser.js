var _    = require('lodash');
var fs   = require('fs');
var path = require('path');
var util = require('util');
var iconv = require('iconv-lite');

var findFiles = require('./utils/find_files');

var ParameterError = require('./errors/parameter_error');
var ParserError    = require('./errors/parser_error');

var app = {};

function Parser(_app) {
    var self = this;

    // global variables
    app = _app;

    // class variables
    self.languages = {};
    self.parsers = {};
    self.parsedFileElements = [];
    self.parsedFiles = [];
    self.countDeprecated = {};

    // load languages
    var languages = Object.keys(app.languages);
    languages.forEach(function(language) {
        if (_.isObject( app.languages[language] )) {
            app.log.debug('inject parser language: ' + language);
            self.addLanguage(language, app.languages[language] );
        } else {
            var filename = app.languages[language];
            app.log.debug('load parser language: ' + language + ', ' + filename);
            self.addLanguage(language, require(filename));
        }
    });

    // load parser
    var parsers = Object.keys(app.parsers);
    parsers.forEach(function(parser) {
        if (_.isObject( app.parsers[parser] )) {
            app.log.debug('inject parser: ' + parser);
            self.addParser(parser, app.parsers[parser] );
        } else {
            var filename = app.parsers[parser];
            app.log.debug('load parser: ' + parser + ', ' + filename);
            self.addParser(parser, require(filename));
        }
    });
}

/**
 * Inherit
 */
util.inherits(Parser, Object);

/**
 * Exports
 */
module.exports = Parser;

/**
 * Add a Language
 */
Parser.prototype.addLanguage = function(name, language) {
    this.languages[name] = language;
};

/**
 * Add a Parser
 */
Parser.prototype.addParser = function(name, parser) {
    this.parsers[name] = parser;
};

/**
 * Parse files in specified folder
 *
 * @param {Object} options The options used to parse and filder the files.
 * @param {Object[]} parsedFiles List of parsed files.
 * @param {String[]} parsedFilenames List of parsed files, with full path.
 */
Parser.prototype.parseFiles = function(options, parsedFiles, parsedFilenames) {
    var self = this;

    findFiles.setPath(options.src);
    findFiles.setExcludeFilters(options.excludeFilters);
    findFiles.setIncludeFilters(options.includeFilters);
    var files = findFiles.search();

    // Parser
    for (var i = 0; i < files.length; i += 1) {
        var filename = options.src + files[i];
        var parsedFile = self.parseFile(filename, options.encoding);
        if (parsedFile) {
            app.log.verbose('parse file: ' + filename);
            parsedFiles.push(parsedFile);
            parsedFilenames.push(filename);
        }
    }
};

/**
 * Execute Fileparsing
 */
Parser.prototype.parseFile = function(filename, encoding) {
    var self = this;

    if (typeof(encoding) === 'undefined')
        encoding = 'utf8';

    app.log.debug('inspect file: ' + filename);

    self.filename = filename;
    self.extension = path.extname(filename).toLowerCase();
    // TODO: Not sure if this is correct. Without skipDecodeWarning we got string errors
    // https://github.com/apidoc/apidoc-core/pull/25
    var fileContent = fs.readFileSync(filename, { encoding: 'binary' });
    iconv.skipDecodeWarning = true;
    self.src = iconv.decode(fileContent, encoding);
    app.log.debug('size: ' + self.src.length);

    // unify line-breaks
    self.src = self.src.replace(/\r\n/g, '\n');

    self.blocks = [];
    self.indexApiBlocks = [];

    // determine blocks
    self.blocks = self._findBlocks();
    if (self.blocks.length === 0)
        return;

    app.log.debug('count blocks: ' + self.blocks.length);

    // determine elements in blocks
    self.elements = self.blocks.map(function(block, i) {
        var elements = self.findElements(block, filename);
        app.log.debug('count elements in block ' + i + ': ' + elements.length);
        return elements;
    });
    if (self.elements.length === 0)
        return;

    // determine list of blocks with API elements
    self.indexApiBlocks = self._findBlockWithApiGetIndex(self.elements);
    if (self.indexApiBlocks.length === 0)
        return;

    return self._parseBlockElements(self.indexApiBlocks, self.elements, filename);
};

/**
 * Parse API Elements with Plugins
 *
 * @param indexApiBlocks
 * @param detectedElements
 * @returns {Array}
 */
Parser.prototype._parseBlockElements = function(indexApiBlocks, detectedElements, filename) {
    var self = this;
    var parsedBlocks = [];

    for (var i = 0; i < indexApiBlocks.length; i += 1) {
        var blockIndex = indexApiBlocks[i];
        var elements = detectedElements[blockIndex];
        var blockData = {
            global: {},
            local : {}
        };
        var countAllowedMultiple = 0;

        for (var j = 0; j < elements.length; j += 1) {
            var element = elements[j];
            var elementParser = self.parsers[element.name];

            if ( ! elementParser) {
                app.log.warn('parser plugin \'' + element.name + '\' not found in block: ' + blockIndex);
            } else {
                app.log.debug('found @' + element.sourceName + ' in block: ' + blockIndex);

                // Deprecation warning
                if (elementParser.deprecated) {
                    self.countDeprecated[element.sourceName] = self.countDeprecated[element.sourceName] ? self.countDeprecated[element.sourceName] + 1 : 1;

                    var message = '@' + element.sourceName + ' is deprecated';
                    if (elementParser.alternative)
                        message = '@' + element.sourceName + ' is deprecated, please use ' + elementParser.alternative;

                    if (self.countDeprecated[element.sourceName] === 1)
                        // show deprecated message only 1 time as warning
                        app.log.warn(message);
                    else
                        // show deprecated message more than 1 time as verbose message
                        app.log.verbose(message);

                    app.log.verbose('in file: ' + filename + ', block: ' + blockIndex);
                }

                var values;
                var preventGlobal;
                var allowMultiple;
                var pathTo;
                var attachMethod;
                try {
                    // parse element and retrieve values
                    values = elementParser.parse(element.content, element.source);

                    // HINT: pathTo MUST be read after elementParser.parse, because of dynamic paths
                    // Add all other options after parse too, in case of a custom plugin need to modify params.

                    // check if it is allowed to add to global namespace
                    preventGlobal = elementParser.preventGlobal === true;

                    // allow multiple inserts into pathTo
                    allowMultiple = elementParser.allowMultiple === true;


                    // path to an array, where the values should be attached
                    pathTo = '';
                    if (elementParser.path) {
                        if (typeof elementParser.path === 'string')
                            pathTo = elementParser.path;
                        else
                            pathTo = elementParser.path(); // for dynamic paths
                    }

                    if ( ! pathTo)
                        throw new ParserError('pathTo is not defined in the parser file.', '', '', element.sourceName);

                    // method how the values should be attached (insert or push)
                    attachMethod = elementParser.method || 'push';

                    if (attachMethod !== 'insert' && attachMethod !== 'push')
                        throw new ParserError('Only push or insert are allowed parser method values.', '', '', element.sourceName);

                    // TODO: put this into "converters"
                    if (values) {
                        // Markdown.
                        if ( app.markdownParser &&
                             elementParser.markdownFields &&
                             elementParser.markdownFields.length > 0
                        ) {
                            for (var markdownIndex = 0; markdownIndex < elementParser.markdownFields.length; markdownIndex += 1) {
                                var field = elementParser.markdownFields[markdownIndex];
                                if (values[field]) {
                                    values[field] = app.markdownParser.render(values[field]);
                                    // remove line breaks
                                    values[field] = values[field].replace(/(\r\n|\n|\r)/g, ' ');

                                    values[field] = values[field].trim();

                                    // TODO: Little hacky, not sure to handle this here or in template
                                    if ( elementParser.markdownRemovePTags &&
                                         elementParser.markdownRemovePTags.length > 0 &&
                                         elementParser.markdownRemovePTags.indexOf(field) !== -1
                                    ) {
                                        // Remove p-Tags
                                        values[field] = values[field].replace(/(<p>|<\/p>)/g, '');
                                    }
                                }
                            }
                        }
                    }
                } catch(e) {
                    if (e instanceof ParameterError) {
                        var extra = [];
                        if (e.definition)
                            extra.push({ 'Definition': e.definition });
                        if (e.example)
                            extra.push({ 'Example': e.example });
                        throw new ParserError(e.message,
                                              self.filename, (blockIndex + 1), element.sourceName, element.source, extra);
                    }
                    throw new ParserError('Undefined error.',
                                          self.filename, (blockIndex + 1), element.sourceName, element.source);
                }

                if ( ! values)
                    throw new ParserError('Empty parser result.',
                                          self.filename, (blockIndex + 1), element.sourceName, element.source);

                if (preventGlobal) {
                    // Check if count global namespace entries > count allowed
                    // (e.g. @successTitle is global, but should co-exist with @apiErrorStructure)
                    if (Object.keys(blockData.global).length > countAllowedMultiple)
                        throw new ParserError('Only one definition or usage is allowed in the same block.',
                                              self.filename, (blockIndex + 1), element.sourceName, element.source);
                }

                // only one global allowed per block
                if (pathTo === 'global' || pathTo.substr(0, 7) === 'global.') {
                    if (allowMultiple) {
                        countAllowedMultiple += 1;
                    } else {
                        if (Object.keys(blockData.global).length > 0)
                            throw new ParserError('Only one definition is allowed in the same block.',
                                                  self.filename, (blockIndex + 1), element.sourceName, element.source);

                        if (preventGlobal === true)
                            throw new ParserError('Only one definition or usage is allowed in the same block.',
                                                  self.filename, (blockIndex + 1), element.sourceName, element.source);
                    }
                }

                if ( ! blockData[pathTo])
                    self._createObjectPath(blockData, pathTo, attachMethod);

                var blockDataPath = self._pathToObject(pathTo, blockData);

                // insert Fieldvalues in Path-Array
                if (attachMethod === 'push')
                    blockDataPath.push(values);
                else
                    _.extend(blockDataPath, values);

                // insert Fieldvalues in Mainpath
                if (elementParser.extendRoot === true)
                    _.extend(blockData, values);

                blockData.index = blockIndex + 1;
            }
        }
        if (blockData.index && blockData.index > 0)
            parsedBlocks.push(blockData);
    }
    return parsedBlocks;
};

/**
 * Create a not existing Path in an Object
 *
 * @param src
 * @param path
 * @param {String} attachMethod Create last element as object or array: 'insert', 'push'
 * @returns {Object}
 */
Parser.prototype._createObjectPath = function(src, path, attachMethod) {
    if ( ! path)
        return src;
    var pathParts = path.split('.');
    var current = src;
    for (var i = 0; i < pathParts.length; i += 1) {
        var part = pathParts[i];
        if ( ! current[part]) {
            if (i === (pathParts.length - 1) && attachMethod === 'push' )
                current[part] = [];
            else
                current[part] = {};
        }
        current = current[part];
    }
    return current;
};


/**
 * Return Path to Object
 */
Parser.prototype._pathToObject = function(path, src) {
    if ( ! path)
        return src;
    var pathParts = path.split('.');
    var current = src;
    for (var i = 0; i < pathParts.length; i += 1) {
        var part = pathParts[i];
        current = current[part];
    }
    return current;
};

/**
 * Determine Blocks
 */
Parser.prototype._findBlocks = function() {
    var self = this;
    var blocks = [];
    var src = self.src;

    // Replace Linebreak with Unicode
    src = src.replace(/\n/g, '\uffff');

    var regexForFile = this.languages[self.extension] || this.languages['default'];
    var matches = regexForFile.docBlocksRegExp.exec(src);
    while (matches) {
        var block = matches[2] || matches[1];

        // Reverse Unicode Linebreaks
        block = block.replace(/\uffff/g, '\n');

        block = block.replace(regexForFile.inlineRegExp, '');
        blocks.push(block);

        // Find next
        matches = regexForFile.docBlocksRegExp.exec(src);
    }
    return blocks;
};

/**
 * Return block indexes with active API-elements
 *
 * An @apiIgnore ignores the block.
 * Other, non @api elements, will be ignored.
 */
Parser.prototype._findBlockWithApiGetIndex = function(blocks) {
    var foundIndexes = [];
    for (var i = 0; i < blocks.length; i += 1) {
        var found = false;
        for (var j = 0; j < blocks[i].length; j += 1) {
            if (blocks[i][j].name.substr(0, 9) === 'apiignore') {
                app.log.debug('apiIgnore found in block: ' + i);
                found = false;
                break;
            }

            if (blocks[i][j].name.substr(0, 3) === 'api')
                found = true;
        }
        if (found) {
            foundIndexes.push(i);
            app.log.debug('api found in block: ' + i);
        }
    }
    return foundIndexes;
};

/**
 * Get Elements of Blocks
 */
Parser.prototype.findElements = function(block, filename) {
    var elements = [];

    // Replace Linebreak with Unicode
    block = block.replace(/\n/g, '\uffff');

    // Elements start with @
    var elementsRegExp = /(@(\w*)\s?(.+?)(?=\uffff[\s\*]*@|$))/gm;
    var matches = elementsRegExp.exec(block);
    while (matches) {
        var element = {
            source    : matches[1],
            name      : matches[2].toLowerCase(),
            sourceName: matches[2],
            content   : matches[3]
        };

        // reverse Unicode Linebreaks
        element.content = element.content.replace(/\uffff/g, '\n');
        element.source = element.source.replace(/\uffff/g, '\n');

        app.hook('parser-find-element-' + element.name, element, block, filename);

        elements.push(element);

        app.hook('parser-find-elements', elements, element, block, filename);

        // next Match
        matches = elementsRegExp.exec(block);
    }
    return elements;
};
