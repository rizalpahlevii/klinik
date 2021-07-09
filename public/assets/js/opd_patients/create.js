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
/******/ 	return __webpack_require__(__webpack_require__.s = 168);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/opd_patients/create.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/opd_patients/create.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(document).ready(function () {
  $('#patientId, #caseId, #doctorId,#paymentMode').select2({
    width: '100%'
  });
  $('#appointmentDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD HH:mm:ss',
    useCurrent: true,
    sideBySide: true
  }));

  if (lastVisit) {
    $('#patientId').val(lastVisit).trigger('change');
    $('#patientId').attr('disabled', true);
  }

  if (isEdit) {
    $('#patientId').attr('disabled', true);
    $('#patientId').trigger('change');
    $('#appointmentDate').data('DateTimePicker').minDate($('#appointmentDate').val());
  } else $('#appointmentDate').data('DateTimePicker').minDate(new Date());

  $('#createOpdPatientForm, #editOpdPatientDepartmentForm').submit(function () {
    $('#patientId').attr('disabled', false);
    $('#btnSave').attr('disabled', true);
  });
});
$('#patientId').on('change', function () {
  if ($(this).val() !== '') {
    $.ajax({
      url: patientCasesUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val()
      },
      success: function success(data) {
        if (data.data.length !== 0) {
          $('#caseId').empty();
          $('#caseId').removeAttr('disabled');
          $.each(data.data, function (i, v) {
            $('#caseId').append($('<option></option>').attr('value', i).text(v));
          });
        } else {
          $('#caseId').prop('disabled', true);
        }
      }
    });
  }

  $('#caseId').empty();
  $('#caseId').prop('disabled', true);
});
$('#doctorId').on('change', function () {
  if ($(this).val() !== '') {
    $.ajax({
      url: doctorOpdChargeUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val()
      },
      success: function success(data) {
        console.log();

        if (data.data.length !== 0) {
          $('#standardCharge').val(data.data[0].standard_charge);
        } else {
          $('#standardCharge').val(0);
        }
      }
    });
  }
});

/***/ }),

/***/ 168:
/*!**********************************************************!*\
  !*** multi ./resources/assets/js/opd_patients/create.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/opd_patients/create.js */"./resources/assets/js/opd_patients/create.js");


/***/ })

/******/ });