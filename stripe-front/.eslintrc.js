module.exports = {
  env: {
    node: true,
    es6: true,
    browser: true
  },
  parser: '@typescript-eslint/parser',
  parserOptions: {
    ecmaVersion: 2018,
    sourceType: 'module',
    ecmaFeatures: {
      jsx: true,
      modules: true,
      experimentalObjectRestSpread: true
    },
    tsconfigRootDir: './',
    project: './tsconfig.json'
  },
  plugins: ['@typescript-eslint', 'react', 'prettier', 'react-hooks', 'import'],
  extends: [
    'plugin:@typescript-eslint/recommended',
    'eslint:recommended',
    'prettier',
    'prettier/react',
    'plugin:import/typescript'
  ],
  root: true,
  rules: {
    '@typescript-eslint/ban-ts-ignore': 'off',
    '@typescript-eslint/explicit-function-return-type': 'off',
    '@typescript-eslint/no-explicit-any': 'off',
    '@typescript-eslint/no-unused-vars': 'warn',
    '@typescript-eslint/explicit-module-boundary-types': 'off',
    '@typescript-eslint/no-empty-function': ['error', {allow: ['arrowFunctions']}],
    'space-before-function-paren': 'off',
    'react/forbid-component-props': ['warn', {forbid: ['style']}],
    'react/jsx-uses-react': 'error',
    'react/jsx-uses-vars': 'error',
    'react/jsx-no-undef': 'error',
    'react/jsx-key': 'error',
    'react/prop-types': 'error',
    'no-use-before-define': 'off',
    'no-unused-vars': 'off',
    'no-console': ['warn'],
    'react/jsx-first-prop-new-line': [1, 'multiline'],
    'react-hooks/rules-of-hooks': 'error',
    'react-hooks/exhaustive-deps': 'warn',
    'import/order': [
      'warn',
      {
        groups: ['builtin', 'external', 'internal', 'parent', 'sibling'],
        alphabetize: {
          order: 'asc'
        },
        pathGroups: [
          {
            pattern: 'react',
            group: 'builtin',
            position: 'before'
          }
        ],
        pathGroupsExcludedImportTypes: ['builtin']
      }
    ]
  },
  overrides: [
    {
      files: ['*.ts', '*.tsx'],
      rules: {
        '@typescript-eslint/explicit-module-boundary-types': ['error']
      }
    }
  ],
  settings: {
    'import/extensions': ['.js', '.jsx', '.ts', '.tsx'],
    'import/resolver': {
      typescript: {},
      node: {
        extensions: ['.js', '.jsx', '.ts', '.tsx']
      }
    }
  }
};
