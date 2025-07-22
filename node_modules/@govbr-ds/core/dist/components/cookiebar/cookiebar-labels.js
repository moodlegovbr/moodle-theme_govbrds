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
/* harmony export */   CookiebarLabels: () => (/* binding */ CookiebarLabels)
/* harmony export */ });
/** Classe para tratamento das labels do cookiebar */
class CookiebarLabels {
  /**
   * Instancia um objeto de labels do cookiebar
   * @param {object} data - Objeto de dados do cookiebar
   */
  constructor(data) {
    this.data = data
  }

  /**
   * Trata a label para a informação de atualização
   * @returns {string} - Label para a informação de atualização
   * @public
   */
  setLastUpdateLabel() {
    return this.data.lastUpdateLabel || 'Última atualização'
  }

  /**
   * Trata a label para o título da lista de grupos de cookies
   * @returns {string} - Label para o título da lista de grupos de cookies
   * @public
   */
  setCookieGroupsLabel() {
    return this.data.cookieGroupsLabel || 'Classes de cookies'
  }

  /**
   * Trata a label para o checkbox geral desselecionado
   * @returns {string} - Label para o checkbox geral desselecionado
   * @public
   */
  setUnselectAllLabel() {
    return this.data.unselectAllLabel || 'Desselecionar tudo'
  }

  /**
   * Trata a label para o checkbox geral selecionado
   * @returns {string} - Label para o checkbox geral selecionado
   * @public
   */
  setSelectAllLabel() {
    return this.data.selectAllLabel || 'Selecionar tudo'
  }

  /**
   * Trata a label para o checkbox geral
   * @returns {string} - Label para o checkbox geral
   * @public
   */
  setCheckAllLabel() {
    if (this.data.selectAll && !this.data.allIndeterminated) {
      return this.setUnselectAllLabel()
    } else {
      return this.setSelectAllLabel()
    }
  }

  /**
   * Trata a label para o checkbox do grupo de cookies desselecionado
   * @returns {string} - Label para o checkbox do grupo de cookies desselecionado
   * @public
   */
  setUnselectAllGroupLabel() {
    return this.data.unselectAllGroupLabel || 'Desselecionar toda classe'
  }

  /**
   * Trata a label para o checkbox do grupo de cookies selecionado
   * @returns {string} - Label para o checkbox do grupo de cookies selecionado
   * @public
   */
  setSelectAllGroupLabel() {
    return this.data.selectAllGroupLabel || 'Selecionar toda classe'
  }

  /**
   * Trata a label para o checkbox do grupo de cookies
   * @param {object} groupData - Objeto com dados de 1 grupo de cookies
   * @returns {string} - Label para checkbox do grupo de cookies
   * @public
   */
  setCheckGroupLabel(groupData) {
    if (groupData.groupSelected && !groupData.groupIndeterminated) {
      return this.setUnselectAllGroupLabel()
    } else {
      return this.setSelectAllGroupLabel()
    }
  }

  /**
   * Trata a label para o grupo de cookies 'opt-in'
   * @returns {string} - Label para grupo de cookies 'opt-in'
   * @public
   */
  setAlwaysActiveLabel() {
    return this.data.alwaysActiveLabel || 'Sempre ativo'
  }

  /**
   * Trata a label para cookie habilitado
   * @returns {string} - Label para cookie habilitado
   * @publi
   */
  setCheckCookieEnabledLabel() {
    return this.data.onLabel || 'Ligado'
  }

  /**
   * Trata a label para cookie desabilitado
   * @returns {string} - Label para cookie desabilitado
   * @public
   */
  setCheckCookieDisabledLabel() {
    return this.data.offLabel || 'Desligado'
  }

  /**
   * Trata a label para o nome do cookie
   * @returns {string} - Label para o nome do cookie
   * @public
   */
  setCookieNameLabel() {
    return this.data.cookieNameLabel || 'Cookies'
  }

  /**
   * Trata a label para o vencimento do cookie
   * @returns {string} - Label para o vencimento do cookie
   * @public
   */
  setCookieExpiresLabel() {
    return this.data.expiresLabel || 'Vencimento'
  }

  /**
   * Trata a label para o domínio do cookie
   * @returns {string} - Label para o domínio do cookie
   * @public
   */
  setCookieDomainLabel() {
    return this.data.domainLabel || 'Domínio'
  }

  /**
   * Trata a label para e empresa do cookie
   * @returns {string} - Label para a empresa do cookie
   * @public
   */
  setCookieEnterpriseLabel() {
    return this.data.enterpriseLabel || 'Empresa'
  }

  /**
   * Trata a label para a finalidade do cookie
   * @returns {string} - Label para a finalidade do cookie
   * @public
   */
  setCookiePurposeLabel() {
    return this.data.purposeLabel || 'Finalidade'
  }

  /**
   * Trata a label para a descrição do cookie
   * @returns {string} - Label para a descrição do cookie
   * @public
   */
  setCookieDescriptionLabel() {
    return this.data.descriptionLabel || 'Descrição'
  }

  /**
   * Trata a label para o botão de políticas/definições de cookies
   * @returns {string} - Label para o botão de políticas/definições de cookies
   * @public
   */
  setPoliticsButtonLabel() {
    return this.data.allOptOut
      ? this.data.optOutButton || 'Definir Cookies'
      : this.data.optInButton || 'Ver Política de Cookies'
  }

  /**
   * Trata a label para o botão de aceite
   * @returns {string} - Label para o botão de aceite
   * @public
   */
  setAcceptButtonLabel() {
    return this.data.acceptButton || 'Aceitar'
  }
}

/******/ 	return __webpack_exports__;
/******/ })()
;
});
//# sourceMappingURL=cookiebar-labels.js.map