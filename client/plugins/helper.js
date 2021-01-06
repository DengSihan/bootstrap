String.prototype.toCapitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};

String.prototype.toCapitalizePhrases = function() {
    return this
        .toLowerCase()
        .split(' ')
        .map(word => word.toCapitalize())
        .join(' ');
}
