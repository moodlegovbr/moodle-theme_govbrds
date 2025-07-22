(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define("core", [], factory);
	else if(typeof exports === 'object')
		exports["core"] = factory();
	else
		root["core"] = factory();
})(self, () => {
return /******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
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
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ACCEPT_BUTTON: () => (/* binding */ ACCEPT_BUTTON),
/* harmony export */   ACTION_BUTTONS: () => (/* binding */ ACTION_BUTTONS),
/* harmony export */   BROAD_ALERT: () => (/* binding */ BROAD_ALERT),
/* harmony export */   BR_CHECKBOX: () => (/* binding */ BR_CHECKBOX),
/* harmony export */   BR_SWITCH: () => (/* binding */ BR_SWITCH),
/* harmony export */   BUTTON_ICON: () => (/* binding */ BUTTON_ICON),
/* harmony export */   CHECKBOX: () => (/* binding */ CHECKBOX),
/* harmony export */   CLOSE_BUTTON: () => (/* binding */ CLOSE_BUTTON),
/* harmony export */   CONTAINER_FLUID: () => (/* binding */ CONTAINER_FLUID),
/* harmony export */   COOKIES_CHECKED: () => (/* binding */ COOKIES_CHECKED),
/* harmony export */   COOKIE_ALERT: () => (/* binding */ COOKIE_ALERT),
/* harmony export */   COOKIE_CARD: () => (/* binding */ COOKIE_CARD),
/* harmony export */   GROUP_ALERT: () => (/* binding */ GROUP_ALERT),
/* harmony export */   GROUP_BUTTON: () => (/* binding */ GROUP_BUTTON),
/* harmony export */   GROUP_INFO: () => (/* binding */ GROUP_INFO),
/* harmony export */   GROUP_NAME: () => (/* binding */ GROUP_NAME),
/* harmony export */   GROUP_SIZE: () => (/* binding */ GROUP_SIZE),
/* harmony export */   MODAL_FOOTER: () => (/* binding */ MODAL_FOOTER),
/* harmony export */   PARENT_CHECKBOX: () => (/* binding */ PARENT_CHECKBOX),
/* harmony export */   POLITICS_BUTTON: () => (/* binding */ POLITICS_BUTTON),
/* harmony export */   WRAPPER: () => (/* binding */ WRAPPER)
/* harmony export */ });
/** Constantes representando seletores para o cookiebar */
const POLITICS_BUTTON = '.actions .br-button.secondary'
const ACCEPT_BUTTON = '.actions .br-button.primary'
const ACTION_BUTTONS = `${POLITICS_BUTTON}, ${ACCEPT_BUTTON}`
const CLOSE_BUTTON = '.br-modal-header .br-button.close'
const CONTAINER_FLUID = '.br-modal > .br-card .container-fluid'
const WRAPPER = '.br-modal > .br-card .wrapper'
const MODAL_FOOTER = '.br-modal > .br-card .br-modal-footer'
const GROUP_INFO = '.main-content .group-info'
const COOKIE_CARD = '.main-content .cookie-info .br-card'
const BROAD_ALERT = '.header .row:nth-child(1) div:nth-child(3) .feedback'
const GROUP_ALERT = '.row:nth-child(1) div:nth-child(4) .feedback'
const COOKIE_ALERT = '.row:nth-child(1) div:nth-child(2) .feedback'
const BR_CHECKBOX = '.br-checkbox input[type="checkbox"]'
const BR_SWITCH = '.br-switch input[type="checkbox"]'
const CHECKBOX = `${BR_CHECKBOX}, ${BR_SWITCH}`
const PARENT_CHECKBOX = '.main-content .br-checkbox input[data-parent]'
const COOKIES_CHECKED = '.main-content .br-item .cookies-checked'
const GROUP_BUTTON = '.main-content .br-item .br-button'
const GROUP_NAME = '.main-content .br-item .group-name'
const GROUP_SIZE = '.main-content .br-item .group-size'
const BUTTON_ICON = '.br-button i.fas'

/******/ 	return __webpack_exports__;
/******/ })()
;
});
//# sourceMappingURL=selectors.js.map