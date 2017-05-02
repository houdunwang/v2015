/**
 * Strips from each line any leading whitespace that is shared by all lines.
 *
 * @param str string
 * @returns string
 */
module.exports = function unindent(str) {
    var lines = str.split('\n');

    var xs = lines.filter(function (x) {
        return /\S/.test(x);
    }).sort();

    if (xs.length === 0)
        return str;

    var a = xs[0];
    var b = xs[xs.length - 1];

    var maxLength = Math.min(a.length, b.length);

    var i = 0;
    while (i < maxLength &&
           /\s/.test(a.charAt(i)) &&
           a.charAt(i) === b.charAt(i)) {
        i += 1;
    }

    if (i === 0)
        return str;

    return lines.map(function (line) {
        return line.substr(i);
    }).join('\n');
};
