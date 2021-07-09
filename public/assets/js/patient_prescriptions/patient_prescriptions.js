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
/******/ 	return __webpack_require__(__webpack_require__.s = 112);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/patient_prescriptions/patient_prescriptions.js":
/*!****************************************************************************!*\
  !*** ./resources/assets/js/patient_prescriptions/patient_prescriptions.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = '#prescriptionsTable';
var tbl = $('#prescriptionsTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'asc']],
  ajax: {
    url: prescriptionUrl,
    data: function data(_data) {
      _data.status = $('#filter_status').find('option:selected').val();
    }
  },
  columnDefs: [{
    'targets': [7],
    'orderable': false,
    'className': 'text-center',
    'width': '10%'
  }, {
    'targets': [8],
    'orderable': false,
    'width': '5%'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: 'patient.user.full_name',
    name: 'patient.user.first_name'
  }, {
    data: 'doctor.user.full_name',
    name: 'doctor.user.first_name'
  }, {
    data: function data(row) {
      return isEmpty(row.medical_history) ? 'N/A' : row.medical_history;
    },
    name: 'medical_history'
  }, {
    data: function data(row) {
      return isEmpty(row.current_medication) ? 'N/A' : row.current_medication;
    },
    name: 'current_medication'
  }, {
    data: function data(row) {
      return isEmpty(row.health_insurance) ? 'N/A' : row.health_insurance;
    },
    name: 'health_insurance'
  }, {
    data: function data(row) {
      return isEmpty(row.low_income) ? 'N/A' : row.low_income;
    },
    name: 'low_income'
  }, {
    data: function data(row) {
      return isEmpty(row.reference) ? 'N/A' : row.reference;
    },
    name: 'reference'
  }, {
    data: function data(row) {
      if (row.status == 0) return 'Deactive';else return 'Active';
    },
    name: 'status'
  }, {
    data: function data(row) {
      var showLink = prescriptionUrl + '/' + row.id;
      return '<a href="' + showLink + '" class="btn action-btn btn-primary btn-sm"><i class="fa fa-eye action-icon"></i></a>';
    },
    name: 'patient.user.last_name'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#filter_status').change(function () {
      $(tableName).DataTable().ajax.reload(null, true);
    });
  }
});

/***/ }),

/***/ 112:
/*!**********************************************************************************!*\
  !*** multi ./resources/assets/js/patient_prescriptions/patient_prescriptions.js ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/patient_prescriptions/patient_prescriptions.js */"./resources/assets/js/patient_prescriptions/patient_prescriptions.js");


/***/ })

/******/ });