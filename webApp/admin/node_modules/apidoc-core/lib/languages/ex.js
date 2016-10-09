/**
 * Elixir
 */
module.exports = {
    // Find document blocks in heredocs that are arguments of the @apidoc
    // module attribute. Elixir heredocs can be enclosed between """ and """ or
    // between ''' and '''. Heredocs in ~s and ~S sigils are also supported.
    docBlocksRegExp: /@apidoc\s*(~[sS])?"""\uffff?(.+?)\uffff?(?:\s*)?"""|@apidoc\s*(~[sS])?'''\uffff?(.+?)\uffff?(?:\s*)?'''/g,
    // Remove not needed tabs at the beginning
    inlineRegExp: /^(\t*)?/gm
};
