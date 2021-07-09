/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 65);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/birth_reports/birth_reports.js":
/*!************************************************************!*\
  !*** ./resources/assets/js/birth_reports/birth_reports.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tbl = $('#birthReportsTbl').DataTable({
  processing: true,
  serverSide: true,
  'order': [[3, 'desc']],
  ajax: {
    url: birthReportUrl
  },
  columnDefs: [{
    'targets': [1],
    'className': 'text-center'
  }, {
    'targets': [4],
    'orderable': false,
    'className': 'text-center',
    'width': '8%'
  }, {
    'targets': [5, 6],
    'visible': false
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      var showLink = patientUrl + '/' + row.patient.id;
      return '<a href="' + showLink + '">' + row.patient.user.full_name + '</a>';
    },
    name: 'patient.user.first_name'
  }, {
    data: function data(row) {
      var showLink = caseUrl + '/' + row.case_from_birth_report.id;
      return '<a href="' + showLink + '">' + row.case_id + '</a>';
    },
    name: 'case_id'
  }, {
    data: function data(row) {
      var showLink = doctorUrl + '/' + row.doctor.id;
      return '<a href="' + showLink + '">' + row.doctor.user.full_name + '</a>';
    },
    name: 'doctor.user.first_name'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.date === null) {
        return 'N/A';
      }

      return moment(row.date).format('Do MMM, Y h:mm A');
    },
    name: 'date'
  }, {
    data: function data(row) {
      var url = birthReportUrl + '/' + row.id;
      var data = [{
        'id': row.id,
        'url': url + '/edit',
        'viewUrl': url
      }];
      return prepareTemplateRender('#birthReportActionTemplate', data);
    },
    name: 'id'
  }, {
    data: 'patient.user.last_name',
    name: 'patient.user.last_name'
  }, {
    data: 'doctor.user.last_name',
    name: 'doctor.user.last_name'
  }]
});
$(document).on('click', '.delete-btn', function (event) {
  var birthReportId = $(event.currentTarget).data('id');
  deleteItem(birthReportUrl + '/' + birthReportId, '#birthReportsTbl', 'Birth Report');
});

/***/ }),

/***/ 65:
/*!******************************************************************!*\
  !*** multi ./resources/assets/js/birth_reports/birth_reports.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/birth_reports/birth_reports.js */"./resources/assets/js/birth_reports/birth_reports.js");


/***/ })

/******/ });