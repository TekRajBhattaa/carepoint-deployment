#!/usr/bin/env node

import fs from 'fs';
import path from 'path';
import yargs from 'yargs'
import glob from 'fast-glob'
import { hideBin } from 'yargs/helpers'
import SVGSpriter from 'svg-sprite';

const { argv } = yargs(hideBin(process.argv)).scriptName("icon-builder.mjs")
    .usage("Usage: $0 -theme <theme>")
    .option("t", {
        alias: "theme",
        describe: "The name of the wordpress theme directory.",
        demandOption: "The theme name is required.",
        type: "string",
    });

const svgoConfig = {
    "log": "info",
    "shape": {
        "id": {
            "generator": (_name, file) => {
                const fileName = file.basename.slice(0, -4);
                return `${fileName}`;
            }
        },
        "dimension": {
            "maxWidth": 48,
            "maxHeight": 48,
            "attributes": true
        },
        "spacing": {
            "padding": 0
        },
        "transform": [
            {
                "svgo": {
                    "plugins": [
                    ]
                }
            }
        ]
    },
    "svg": {
        "xmlDeclaration": true
    },
    "mode": {
        "symbol": {
            "dest": "./",
            "sprite": `./web/ico.svg`,
            "inline": true,
            "example": {
                "template": "./src/icons-template.html.hbs",
                "dest": `./web/app/themes/${argv.theme}/static/icons.html`
            }
        }
    },
    "variables": {}
};

// eslint-disable-next-line no-console
console.log(`Build icons for theme: ${argv.theme}`);

const spriter = new SVGSpriter(svgoConfig);
const files = glob.sync(`./web/app/themes/${argv.theme}/src/icons/*.svg`);
for (const file of files) {
    spriter.add(file, file, fs.readFileSync(file, 'utf8'));
}

spriter.compile((error, result, _data) => {
    // Run through all files that have been created for the `symbol` mode
    for (const type of Object.values(result.symbol)) {
        // Recursively create directories as needed
        fs.mkdirSync(path.dirname(type.path), { recursive: true });
        // Write the generated resource to disk
        fs.writeFileSync(type.path, type.contents);
    }
});
