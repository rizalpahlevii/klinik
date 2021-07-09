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
/******/ 	return __webpack_require__(__webpack_require__.s = 74);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/employee/my_payrolls.js":
/*!*****************************************************!*\
  !*** ./resources/assets/js/employee/my_payrolls.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tbl = $('#employeePayrollsTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'asc']],
  ajax: {
    url: employeePayrollUrl
  },
  columnDefs: [{
    'targets': [0],
    'className': 'text-center'
  }, {
    'targets': [3, 4, 5, 6],
    'className': 'text-right'
  }, {
    'targets': [7],
    'orderable': false,
    'className': 'text-center'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      var showLink = payrollUrl + '/' + row.id;
      return '<a href="' + showLink + '">' + row.payroll_id + '</a>';
    },
    name: 'payroll_id'
  }, {
    data: 'month',
    name: 'month'
  }, {
    data: 'year',
    name: 'year'
  }, {
    data: function data(row) {
      return !isEmpty(row.basic_salary) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.basic_salary) + '</p>' : 'N/A';
    },
    name: 'basic_salary'
  }, {
    data: function data(row) {
      return !isEmpty(row.allowance) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.allowance) + '</p>' : 'N/A';
    },
    name: 'allowance'
  }, {
    data: function data(row) {
      return !isEmpty(row.deductions) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.deductions) + '</p>' : 'N/A';
    },
    name: 'deductions'
  }, {
    data: function data(row) {
      return !isEmpty(row.net_salary) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.net_salary) + '</p>' : 'N/A';
    },
    name: 'net_salary'
  }, {
    data: function data(row) {
      if (row.status == 1) return 'Paid';else return 'Unpaid';
    },
    name: 'net_salary'
  }]
});

/***/ }),

/***/ 74:
/*!***********************************************************!*\
  !*** multi ./resources/assets/js/employee/my_payrolls.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/employee/my_payrolls.js */"./resources/assets/js/employee/my_payrolls.js");


/***/ })

/******/ });