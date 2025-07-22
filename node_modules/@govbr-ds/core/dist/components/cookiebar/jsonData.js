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
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
const jsonData = `[
  {
    "lang": "pt-br",
    "allOptOut": true,
    "acceptButton": "Aceitar",
    "optOutButton": "Definir Cookies",
    "optInButton": "Ver Política de Cookies",
    "infoText": "Minim pariatur amet laboris sint consectetur enim do voluptate",
    "mainTitle": "Exercitation et proident",
    "lastUpdate": "01/02/2021",
    "entryText": "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus aspernatur neque culpa nisi alias. Voluptatem dicta nihil magnam, cumque voluptatum animi distinctio molestias recusandae ipsam, sapiente unde error repellendus quibusdam?",
    "selectAll": false,
    "allAlertMessage": "Ao desativar qualquer Cookie, sua navegação poderá ser comprometida",
    "closeLabel": "fechar tela de seleção de cookies",
    "lastUpdateLabel": "Última atualização",
    "cookieGroupsLabel": "Classes de cookies",
    "selectAllLabel": "Selecionar tudo",
    "unselectAllLabel": "Desselecionar tudo",
    "selectAllGroupLabel": "Selecionar toda classe",
    "unselectAllGroupLabel": "Desselecionar toda classe",
    "onLabel": "Ligado",
    "offLabel": "Desligado",
    "alwaysActiveLabel": "Sempre ativo",
    "cookieNameLabel": "Cookies",
    "expiresLabel": "Vencimento",
    "domainLabel": "Domínio",
    "enterpriseLabel": "Empresa",
    "purposeLabel": "Finalidade",
    "descriptionLabel": "Descrição",
    "cookieGroups": [
      {
        "groupId": "necessarios",
        "groupName": "Estritamente necessários",
        "groupOptOut": false,
        "groupSelected": false,
        "groupAlertMessage": "Alerta group 0",
        "groupText": "Descrição do Grupo de Cookies.",
        "cookieList": [
          {
            "cookieId": "necessario-1",
            "cookieOptOut": false,
            "cookieSelected": false,
            "alertMessage": "Alerta group 0 - cookie 0",
            "cookieName": "optimizelyEndUserId",
            "expires": "30 minutos",
            "domain": "serpro.gov.br",
            "enterprise": "Serpro",
            "purpose": "Autorização",
            "description": "Descrição do Cookie"
          },
          {
            "cookieId": "necessario-2",
            "cookieOptOut": false,
            "cookieSelected": false,
            "alertMessage": "Alerta group 0 - cookie 1",
            "cookieName": "optimizelyEndUserId",
            "expires": "30 minutos",
            "domain": "serpro.gov.br",
            "enterprise": "Serpro",
            "purpose": "Autorização",
            "description": "Descrição do Cookie"
          }
        ]
      },
      {
        "groupId": "desempenho",
        "groupName": "Desempenho, funcionamento, marketing e personalização",
        "groupOptOut": true,
        "groupSelected": true,
        "groupAlertMessage": "Ao desativar um Cookie do grupo Desempenho, o desempenho do site pode ser comprometido.",
        "groupText": "Descrição do Grupo de Cookies.",
        "cookieList": [
          {
            "cookieId": "desempenho-2",
            "cookieOptOut": true,
            "cookieSelected": false,
            "alertMessage": "Ao desativar o Cookie desempenho 2, o desempenho do site pode ser comprometido.",
            "cookieName": "optimizelyEndUserId",
            "expires": "30 minutos",
            "domain": "serpro.gov.br",
            "enterprise": "Serpro",
            "purpose": "Autorização",
            "description": "Descrição do Cookie"
          },
          {
            "cookieId": "desempenho-3",
            "cookieOptOut": true,
            "cookieSelected": false,
            "cookieName": "optimizelyEndUserId",
            "expires": "30 minutos",
            "domain": "serpro.gov.br",
            "enterprise": "Serpro",
            "purpose": "Autorização",
            "description": "Descrição do Cookie"
          }
        ]
      },
      {
        "groupId": "experiencia",
        "groupName": "Experiência do site",
        "groupOptOut": true,
        "groupSelected": false,
        "groupAlertMessage": "Ao desativar algum Cookie do Grupo Experiência do site, sua navegação ficará comprometida.",
        "groupText": "Descrição do Grupo de Cookies.",
        "cookieList": [
          {
            "cookieId": "experiencia-1",
            "cookieOptOut": true,
            "cookieSelected": false,
            "alertMessage": "Ao desativar o Cookie experiencia-1, sua navegação ficará comprometida.",
            "cookieName": "optimizelyEndUserId",
            "expires": "30 minutos",
            "domain": "serpro.gov.br",
            "enterprise": "Serpro",
            "purpose": "Autorização",
            "description": "Descrição do Cookie"
          },
          {
            "cookieId": "experiencia-2",
            "cookieOptOut": true,
            "cookieSelected": false,
            "alertMessage": "Ao desativar o Cookie experiencia-1, sua navegação ficará comprometida.",
            "cookieName": "optimizelyEndUserId",
            "expires": "30 minutos",
            "domain": "serpro.gov.br",
            "enterprise": "Serpro",
            "purpose": "Autorização",
            "description": "Descrição do Cookie"
          }
        ]
      }
    ],
    "noteTitle": "Aviso sobre cookies",
    "noteList": [
      {
        "question": "O que são cookies?",
        "answer": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam eius distinctio rerum ad, maxime alias vel minima, asperiores sequi eveniet non optio officiis quaerat reiciendis quae odio explicabo ut debitis?"
      },
      {
        "question": "Durabilidade?",
        "answer": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam eius distinctio rerum ad, maxime alias vel minima, asperiores sequi eveniet non optio officiis quaerat reiciendis quae odio explicabo ut debitis?"
      },
      {
        "question": "Proveniência?",
        "answer": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam eius distinctio rerum ad, maxime alias vel minima, asperiores sequi eveniet non optio officiis quaerat reiciendis quae odio explicabo ut debitis?"
      },
      {
        "question": "Finalidade?",
        "answer": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam eius distinctio rerum ad, maxime alias vel minima, asperiores sequi eveniet non optio officiis quaerat reiciendis quae odio explicabo ut debitis?"
      }
    ],
    "links": [
      {
        "name": "Declaração de Conformidade com os Princípios de Proteção de Dados",
        "url": "#"
      }
    ]
  }
]`

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (jsonData);

/******/ 	return __webpack_exports__;
/******/ })()
;
});
//# sourceMappingURL=jsonData.js.map