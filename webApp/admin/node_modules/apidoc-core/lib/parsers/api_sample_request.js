var trim = require('../utils/trim');

function parse(content) {
    var url = trim(content);

    if(url.length === 0)
        return null;

    return {
        url: url
    };
}

/**
 * Exports
 */
module.exports = {
    parse : parse,
    path  : 'local.sampleRequest',
    method: 'push'
};
