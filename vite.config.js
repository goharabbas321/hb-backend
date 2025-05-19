import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import html from '@rollup/plugin-html';
import { glob } from 'glob';
import laravelTranslations from 'vite-plugin-laravel-translations';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
    /**
     * Get Files from a directory
     * @param {string} query
     * @returns array
     */
    function GetFilesArray(query) {
        return glob.sync(query);
    }
    /**
     * Js Files
     */
    // Page JS Files
    const pageJsFiles = GetFilesArray('resources/assets/js/**/*.js');

    // Processing Vendor JS Files
    const vendorJsFiles = GetFilesArray('resources/assets/vendor/js/*.js');

    // Processing Libs JS Files
    const LibsJsFiles = GetFilesArray('resources/assets/vendor/libs/**/*.js');

    /**
     * Scss Files
     */
    // Processing Core, Themes & Pages Scss Files
    const CoreScssFiles = GetFilesArray('resources/assets/vendor/scss/**/!(_)*.scss');

    // Processing Libs Scss & Css Files
    const LibsScssFiles = GetFilesArray('resources/assets/vendor/libs/**/!(_)*.scss');
    const LibsCssFiles = GetFilesArray('resources/assets/vendor/libs/**/*.css');

    // Processing Fonts Scss Files
    const FontsScssFiles = GetFilesArray('resources/assets/vendor/fonts/!(_)*.scss');

    // Processing Window Assignment for Libs like pdfMake
    function libsWindowAssignment() {
        return {
            name: 'libsWindowAssignment',

            transform(src, id) {
                if (id.includes('vfs_fonts')) {
                    return src.replaceAll('this.pdfMake', 'window.pdfMake');
                }
            }
        };
    }

    const paths = [];

    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

    return defineConfig({
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/assets/css/demo.css',
                    'resources/js/app.js',
                    ...allPaths,
                    ...pageJsFiles,
                    ...vendorJsFiles,
                    ...LibsJsFiles,
                    ...CoreScssFiles,
                    ...LibsScssFiles,
                    ...LibsCssFiles,
                    ...FontsScssFiles
                ],
                refresh: true
            }),
            html(),
            libsWindowAssignment(),
            laravelTranslations({
                // # TBC: To include JSON files
                includeJson: false,
                // # Declare: namespace (string|false)
                namespace: false
                //absoluteLanguageDirectory: 'resources/lang',
            })
        ]
    });
}

export default getConfig();
