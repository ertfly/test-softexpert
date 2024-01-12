let Helper = {
    httpGet(name, defaultValue = '') {
        let url = window.location.href;
        name = name.replace(/[[]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);

        if (!results) return defaultValue;
        if (!results[2]) return defaultValue;
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    },
    isNullEmpty(value) {
        if (typeof (value) == 'undefined') {
            return true;
        }

        if (value === null) {
            return true;
        }

        if (typeof (value) === 'string' && value.toString().trim() === '') {
            return true;
        }

        return false;
    },
    nl2br(str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
}

export default Helper