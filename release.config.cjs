/**
 * @type {import('semantic-release').GlobalConfig}
 */
module.exports = {
    branches: [
        {'name': 'main', 'channel': 'latest', 'prerelease': false},
        {'name': 'master', 'channel': 'latest', 'prerelease': false},
        {'name': 'beta', 'prerelease': "beta"},
    ],
    debug: true,
    plugins: [
        ['@semantic-release/commit-analyzer', {
            preset: 'angular',
            parserOpts: {
                headerPattern: /(\w*)(?:\((.*)\))?: (.*)$/,
            }
        }],
        ["@semantic-release/release-notes-generator", {
            preset: 'angular',
            parserOpts: {
                headerPattern: /(\w*)(?:\((.*)\))?: (.*)$/,
            }
        }],
        [
            "@semantic-release/changelog", {
            "changelogFile": "CHANGELOG.md"
        }
        ],
        // Enable the next line if the project is a GitHub / NPM package
        // "@semantic-release/npm",
        "@semantic-release/github",
        [
            "@semantic-release/git",
            {
                "assets": ["composer.json", "package.json", "package-lock.json", "CHANGELOG.md"],
                "message": "chore(release): ${nextRelease.version} \n\n${nextRelease.notes}"
            }
        ]
    ],
};