/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/base_url.js":
/*!**********************************!*\
  !*** ./resources/js/base_url.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "base_url": () => (/* binding */ base_url)
/* harmony export */ });
var base_url = "https://tukon.asia-one.co.id";


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************!*\
  !*** ./resources/js/app_client.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _base_url_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./base_url.js */ "./resources/js/base_url.js");

$(document).ready(function () {
  var src = _base_url_js__WEBPACK_IMPORTED_MODULE_0__.base_url + '/sound/notif.mp3';
  var audio = new Audio(src);
  var notif = $('#notif_klunting');
  $.ajax({
    url: _base_url_js__WEBPACK_IMPORTED_MODULE_0__.base_url + "/client/notification/count/" + unix_id,
    type: "GET",
    dataType: "json",
    success: function success(data) {
      notif.text(data[0]);

      if (notif.text !== 0) {
        notif.show();
      }
    },
    error: function error(_error) {
      console.log(_error);
    }
  });
  var channel = window.Echo.channel('private-user.' + unix_id).listenToAll(function (event, data) {
    // do what you need to do based on the event name and data
    // console.log(event, data)
    notif.text(data.unReadNotif);

    if (notif.text !== 0) {
      notif.show();
    }

    audio.play();
  });
});
})();

/******/ })()
;