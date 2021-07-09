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
/******/ 	return __webpack_require__(__webpack_require__.s = 115);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/employee/patient_admission.js":
/*!***********************************************************!*\
  !*** ./resources/assets/js/employee/patient_admission.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var patientAdmissionsTable = '#patientAdmissionsTbl';
var tbl = $(patientAdmissionsTable).DataTable({
  processing: true,
  serverSide: true,
  'order': [[2, 'desc']],
  ajax: {
    url: patientAdmissionsUrl,
    data: function data(_data) {
      _data.status = $('#filter_status').find('option:selected').val();
    }
  },
  columnDefs: [{
    'targets': [0],
    'width': '10%',
    'className': 'text-center'
  }, {
    'targets': [8],
    'width': '5%',
    'orderable': false,
    'className': 'text-center'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      var showLink = patientAdmissionsUrl + '/' + row.id;
      return '<a href="' + showLink + '">' + row.patient_admission_id + '</a>';
    },
    name: 'patient_admission_id'
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
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.admission_date === null) {
        return 'N/A';
      }

      return moment(row.admission_date).format('Do MMM, Y h:mm A');
    },
    name: 'admission_date'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.discharge_date === null) {
        return 'N/A';
      }

      return moment(row.discharge_date).format('Do MMM, Y h:mm A');
    },
    name: 'discharge_date'
  }, {
    data: function data(row) {
      if (isEmpty(row.package_id)) {
        return 'N/A';
      }

      var showLink = packageUrl + '/' + row["package"].id;
      return '<a href="' + showLink + '">' + row["package"].name + '</a>';
    },
    name: 'package.name'
  }, {
    data: function data(row) {
      if (isEmpty(row.insurance_id)) {
        return 'N/A';
      }

      var showLink = insuranceUrl + '/' + row.insurance.id;
      return '<a href="' + showLink + '">' + row.insurance.name + '</a>';
    },
    name: 'insurance.name'
  }, {
    data: function data(row) {
      return isEmpty(row.policy_no) ? 'N/A' : row.policy_no;
    },
    name: 'policy_no'
  }, {
    data: function data(row) {
      return row.status == 0 ? 'Deactive' : 'Active';
    },
    name: 'status'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#filter_status').change(function () {
      $(patientAdmissionsTable).DataTable().ajax.reload(null, true);
    });
  }
});

/***/ }),

/***/ 115:
/*!*****************************************************************!*\
  !*** multi ./resources/assets/js/employee/patient_admission.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/employee/patient_admission.js */"./resources/assets/js/employee/patient_admission.js");


/***/ })

/******/ });