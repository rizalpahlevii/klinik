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
/******/ 	return __webpack_require__(__webpack_require__.s = 99);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/patient_cases_list/patient_cases_list.js":
/*!**********************************************************************!*\
  !*** ./resources/assets/js/patient_cases_list/patient_cases_list.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tbl = $('#patientCasesTbl').DataTable({
  processing: true,
  serverSide: true,
  'order': [[1, 'desc']],
  ajax: {
    url: patientCasesUrl
  },
  columnDefs: [{
    targets: '_all',
    defaultContent: 'N/A'
  }, {
    'targets': [0],
    'className': 'text-center',
    'width': '10%'
  }, {
    'targets': [5],
    'className': 'text-right'
  }, {
    'targets': [1],
    'width': '15%'
  }, {
    'targets': [6],
    'orderable': false,
    'className': 'text-center',
    'width': '6%'
  }, {
    'targets': [7, 8],
    'visible': false
  }],
  columns: [{
    data: function data(row) {
      var showLink = patientCaseShowUrl + '/' + row.id;
      return '<a href="' + showLink + '">' + row.case_id + '</a>';
    },
    name: 'case_id'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.date === null) {
        return '';
      }

      return moment(row.date).format('Do MMM, Y h:mm A');
    },
    name: 'date'
  }, {
    data: function data(row) {
      var showLink = patientUrl + '/' + row.patient.id;
      return '<a href="' + showLink + '">' + row.patient.user.full_name + '</a>';
    },
    name: 'patient.user.first_name'
  }, {
    data: function data(row) {
      return row.doctor.user.full_name;
    },
    name: 'doctor.user.first_name'
  }, {
    data: 'phone',
    name: 'phone'
  }, {
    data: function data(row) {
      return !isEmpty(row.fee) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.fee) + '</p>' : 'N/A';
    },
    name: 'fee'
  }, {
    data: function data(row) {
      if (row.status == 1) return 'Active';else return 'Deactive';
    },
    name: 'status'
  }, {
    data: function data(row) {
      var showLink = patientCaseShowUrl + '/' + row.id;
      return '<a title="Show" class="btn action-btn btn-primary btn-sm mr-1" href="' + showLink + '">' + '<i class="fa fa-eye action-icon p-case-list-color"></i>' + '</a>';
    },
    name: 'id'
  }, {
    data: 'patient.user.first_name',
    name: 'patient.user.first_name',
    visible: false
  }, {
    data: 'doctor.user.last_name',
    name: 'doctor.user.last_name',
    visible: false
  }]
});

/***/ }),

/***/ 99:
/*!****************************************************************************!*\
  !*** multi ./resources/assets/js/patient_cases_list/patient_cases_list.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/patient_cases_list/patient_cases_list.js */"./resources/assets/js/patient_cases_list/patient_cases_list.js");


/***/ })

/******/ });