/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/test.js ***!
  \******************************/
fetch('/api/test') // Запрос через fetch (чистый JS)
.then(function (response) {
  return response.json();
}).then(function (users) {
  return console.log(users);
});
$.ajax({
  // Запрос через jquery
  url: 'api/test',
  dataType: 'json',
  data: {
    id: 1
  },
  success: function success(user) {
    for (key in user) {
      console.log(key, user[key]);
    }
  }
});
/******/ })()
;