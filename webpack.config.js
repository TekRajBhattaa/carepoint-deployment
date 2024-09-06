const path = require('path');
const { readFileSync } = require('fs');
const { sync: glob } = require('fast-glob');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const { fromProjectRoot } = require('@wordpress/scripts/utils/file.js')
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

// Path for auto. block.json scan
const getWordPressSrcDirectory = () => 'web/app/mu-plugins/vdplug/src'

/**
 * Return list of CSS entry points
 *
 * @return {Object<string,string>|void} The list of entry points.
 */
function getBlockModsCSS() {
    const blockModsPath = 'web/app/mu-plugins/vdplug/src/blocks-mod';
    const blockModsCSSFiles = glob(
        `${blockModsPath}/**/*.css`,
        {
            absolute: true,
        }
    );
    if (blockModsCSSFiles.length > 0) {
        const srcDirectory = fromProjectRoot(
            getWordPressSrcDirectory() + path.sep
        );
        const modsCSS = {};
        blockModsCSSFiles.forEach(name => {
            const entryName = name
                .replace(path.sep + path.basename(name), '')
                .replace(srcDirectory, '')
                .replace(/\\/g, '/');

            modsCSS[entryName] = name;
        });

        return modsCSS;
    }
}

/**
 * Detects the list of entry points to use with webpack. There are three ways to do this:
 *  1. Use the legacy webpack 4 format passed as CLI arguments.
 *  2. Scan `block.json` files for scripts.
 *
 * @see https://webpack.js.org/concepts/entry-points/
 *
 * @return {Object<string,string>|void} The list of entry points.
 */
function getWebpackEntryPoints() {
    // 2. Checks whether any block metadata files can be detected in the defined source directory.
    //    It scans all discovered files looking for JavaScript assets and converts them to entry points.
    const blockMetadataFiles = glob(
        `${getWordPressSrcDirectory()}/blocks/**/block.json`,
        {
            absolute: true,
        }
    );

    if (blockMetadataFiles.length > 0) {
        const srcDirectory = fromProjectRoot(
            getWordPressSrcDirectory() + path.sep
        );
        const entryPoints = blockMetadataFiles.reduce(
            (accumulator, blockMetadataFile) => {
                const { editorScript, script, viewScript } = JSON.parse(
                    readFileSync(blockMetadataFile)
                );
                [editorScript, script, viewScript]
                    .flat()
                    .filter((value) => value && value.startsWith('file:'))
                    .forEach((value) => {
                        // Removes the `file:` prefix.
                        const filepath = path.join(
                            path.dirname(blockMetadataFile),
                            value.replace('file:', '')
                        );

                        // Takes the path without the file extension, and relative to the defined source directory.
                        if (!filepath.startsWith(srcDirectory)) {
                            console.warn(
                                `Skipping "${value.replace(
                                    'file:',
                                    ''
                                )}" listed in "${blockMetadataFile.replace(
                                    fromProjectRoot(path.sep),
                                    ''
                                )}". File is located outside of the "${getWordPressSrcDirectory()}" directory.`
                            );
                            return;
                        }
                        const entryName = filepath
                            .replace(path.extname(filepath), '')
                            .replace(srcDirectory, '')
                            .replace(/\\/g, '/');

                        // Detects the proper file extension used in the defined source directory.
                        const [entryFilepath] = glob(
                            `${getWordPressSrcDirectory()}/${entryName}.[jt]s?(x)`,
                            {
                                absolute: true,
                            }
                        );

                        if (!entryFilepath) {
                            console.warn(
                                `Skipping "${value.replace(
                                    'file:',
                                    ''
                                )}" listed in "${blockMetadataFile.replace(
                                    fromProjectRoot(path.sep),
                                    ''
                                )}". File does not exist in the "${getWordPressSrcDirectory()}" directory.`
                            );

                            return;
                        }
                        accumulator[entryName] = entryFilepath;
                    });
                return accumulator;
            },
            {}
        );

        if (Object.keys(entryPoints).length > 0) {
            return entryPoints;
        }
    }
}

const webpackConfig = [
    // PLUGIN: vdplug
    {
        ...defaultConfig,
        name: 'vdplug',
        entry: {
            // ...defaultConfig.entry(),
            ...getBlockModsCSS(),
            ...getWebpackEntryPoints(),
            editor: './web/app/mu-plugins/vdplug/src/editor.js',
        },
        output: {
            path: path.join(__dirname, 'web/app/mu-plugins/vdplug/build')
        },
        watchOptions: {
            ignored: ['**/vendor', '**/node_modules'],
        },
        module: {
            ...defaultConfig.module,
            rules: [...defaultConfig.module.rules],
        },
        plugins: [
            ...defaultConfig.plugins,
            new CopyWebpackPlugin({
                patterns: [
                    {
                        from: "**/*.(php|json)",
                        to: "../build/blocks/",
                        context: "web/app/mu-plugins/vdplug/src/blocks/",
                    },
                ],
            }),
        ],
    },

    // THEME: vdclassic
    {
        ...defaultConfig,
        name: 'vdclassic',
        entry: {
            // ...defaultConfig.entry(),
            gforms_extend: './web/app/themes/vdclassic/src/plugins/gform/gforms.css',
            vdclassic: './web/app/themes/vdclassic/src/index.ts',
            vdjobs: './web/app/themes/vdclassic/src/vdjobs.js',
        },
        output: {
            path: path.join(__dirname, 'web/app/themes/vdclassic/build')
        },
        watchOptions: {
            ignored: ['**/vendor', '**/node_modules'],
        },
        module: {
            ...defaultConfig.module,
            rules: [...defaultConfig.module.rules],
        },
    }
];

module.exports = webpackConfig;
