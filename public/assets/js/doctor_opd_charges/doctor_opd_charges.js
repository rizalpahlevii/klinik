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
/******/ 	return __webpack_require__(__webpack_require__.s = 126);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/doctor_opd_charges/doctor_opd_charges.js":
/*!**********************************************************************!*\
  !*** ./resources/assets/js/doctor_opd_charges/doctor_opd_charges.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  $('#addModal, #editModal').on('shown.bs.modal', function () {
    $('#doctorId, #editDoctorId:first').focus();
  });
  $('#doctorId, #editDoctorId').select2({
    width: '100%'
  });
  var tableName = '#doctorOPDChargeTable';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'desc']],
    ajax: {
      url: doctorOPDChargeUrl
    },
    columnDefs: [{
      'targets': [2],
      'orderable': false,
      'className': 'text-center',
      'width': '10%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }, {
      'targets': [1],
      'className': 'text-right',
      'width': '15%'
    }],
    columns: [{
      data: 'doctor.user.full_name',
      name: 'doctor.user.first_name'
    }, {
      data: function data(row) {
        return !isEmpty(row.standard_charge) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.standard_charge) + '</p>' : 'N/A';
      },
      name: 'standard_charge'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#doctorOPDChargeTemplate', data);
      },
      name: 'id'
    }]
  });
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');
    $.ajax({
      url: doctorOPDChargeCreateUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addModal').modal('hide');
          tbl.ajax.reload(null, false);
        }
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
      },
      complete: function complete() {
        loadingButton.button('reset');
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(doctorOPDChargeUrl + '/' + id, tableName, 'Doctor OPD Charge');
  });
  $(document).on('click', '.edit-btn', function (event) {
    var doctorOPDChargeId = $(event.currentTarget).data('id');
    renderData(doctorOPDChargeId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: doctorOPDChargeUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#doctorOPDChargeId').val(result.data.id);
          $('#editDoctorId').val(result.data.doctor_id).trigger('change.select2');
          $('#editStandardCharge').val(result.data.standard_charge);
          $('.price-input').trigger('input');
          $('#editModal').modal('show');
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  };

  $(document).on('submit', '#editForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnEditSave');
    loadingButton.button('loading');
    var id = $('#doctorOPDChargeId').val();
    $.ajax({
      url: doctorOPDChargeUrl + '/' + id,
      type: 'patch',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        UnprocessableInputError(result);
      },
      complete: function complete() {
        loadingButton.button('reset');
      }
    });
  });
  $('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#doctorId').val('').trigger('change.select2');
  });
  $('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
  });
});

/***/ }),

/***/ 126:
/*!****************************************************************************!*\
  !*** multi ./resources/assets/js/doctor_opd_charges/doctor_opd_charges.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/doctor_opd_charges/doctor_opd_charges.js */"./resources/assets/js/doctor_opd_charges/doctor_opd_charges.js");


/***/ })

/******/ });