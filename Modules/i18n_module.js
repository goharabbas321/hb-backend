const translations = window.translations; // Get All The Translations

export default function __(key) {
    try {
        let keys = key.split('.');
        let translated_key = 'not_found';
        if (keys.length == 2) {
            translated_key = translations?.[keys[0]]?.[keys[1]];
        } else if (keys.length == 3) {
            translated_key = translations?.[keys[0]]?.[keys[1]]?.[keys[2]];
        } else if (keys.length == 4) {
            translated_key = translations?.[keys[0]]?.[keys[1]]?.[keys[2]]?.[keys[3]];
        } else if (keys.length == 5) {
            translated_key = translations?.[keys[0]]?.[keys[1]]?.[keys[2]]?.[keys[3]]?.[keys[4]];
        } else if (keys.length == 6) {
            translated_key = translations?.[keys[0]]?.[keys[1]]?.[keys[2]]?.[keys[3]]?.[keys[4]]?.[keys[5]];
        } else if (keys.length == 7) {
            translated_key = translations?.[keys[0]]?.[keys[1]]?.[keys[2]]?.[keys[3]]?.[keys[4]]?.[keys[5]]?.[keys[6]];
        } else if (keys.length == 8) {
            translated_key = translations?.[keys[0]]?.[keys[1]]?.[keys[2]]?.[keys[3]]?.[keys[4]]?.[keys[5]]?.[keys[6]]?.[keys[7]];
        }
        return translated_key || key;
    } catch (error) {
        return key;
    }
}
