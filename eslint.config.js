export default [
  {
    languageOptions: {
      ecmaVersion: "latest",
      sourceType: "module"
    },
    plugins: {
      html: require("eslint-plugin-html"),
      css: require("eslint-plugin-css-modules")
    },
    rules: {
      "indent": ["error", 2],
      "quotes": ["error", "double"],
      "semi": ["error", "always"],
      "no-trailing-spaces": "error",
      "max-len": ["error", { "code": 80 }],
      "css-modules/no-unused-class": "warn",
      "css-modules/no-undef-class": "warn"
    }
  }
];
