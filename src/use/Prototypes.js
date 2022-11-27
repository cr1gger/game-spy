export const initPrototypes = () => {

    // Array diff
    Array.prototype.diff = function(a) {
        return this.filter( (i) => {
            return a.indexOf(i) < 0;
        });
    };

}
