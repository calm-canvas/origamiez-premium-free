const wordpress = require('@wordpress/eslint-plugin');
const prettier = require('eslint-config-prettier');

module.exports = [
	{
		ignores: [
			'origamiez/js/**',
			'origamiez/plugins/**',
			'origamiez/css/**',
			'node_modules/**',
			'.pnpm-store/**',
			'vendor/**',
			'dist/**',
			'build/**',
			'**/*.min.js',
			'**/*.min.css',
			'plugins/**',
			'docs/**',
			'guidelines/**',
			'.vscode/**',
			'.idea/**',
			'coverage/**',
			'test-output/**',
			'reports/**',
			'.sonar/**',
			'.snapshots/**',
			'.cache/**',
			'.agent-relay/**',
		],
	},
	...wordpress.configs.recommended,
	prettier,
	{
		files: ['**/*.{js,jsx,mjs,cjs}'],
		languageOptions: {
			globals: {
				jQuery: 'readonly',
				origamiez_vars: 'readonly',
			},
		},
		rules: {
			camelcase: 'off',
			'no-unused-vars': ['error', { argsIgnorePattern: '^_' }],
			'react/react-in-jsx-scope': 'off',
			'react/prop-types': 'off',
		},
		settings: {
			react: {
				version: '18.2.0',
			},
		},
	},
	{
		files: ['**/*.{ts,tsx}'],
		languageOptions: {
			globals: {
				jQuery: 'readonly',
				origamiez_vars: 'readonly',
			},
		},
		rules: {
			camelcase: 'off',
			'@typescript-eslint/no-unused-vars': [
				'error',
				{ argsIgnorePattern: '^_' },
			],
			'react/react-in-jsx-scope': 'off',
			'react/prop-types': 'off',
		},
		settings: {
			react: {
				version: '18.2.0',
			},
		},
	},
];
