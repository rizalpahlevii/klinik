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
/******/ 	return __webpack_require__(__webpack_require__.s = 185);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/blood_donations/blood_donations.js":
/*!****************************************************************!*\
  !*** ./resources/assets/js/blood_donations/blood_donations.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tbl = $('#bloodDonationTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'desc']],
  ajax: {
    url: bloodDonationUrl
  },
  columnDefs: [{
    'targets': [2],
    'orderable': false,
    'className': 'text-center',
    'width': '5%'
  }, {
    'targets': [1],
    'className': 'text-right'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: 'blooddonor.name',
    name: 'blooddonor.name'
  }, {
    data: 'bags',
    name: 'bags'
  }, {
    data: function data(row) {
      var data = [{
        'id': row.id
      }];
      return prepareTemplateRender('#bloodDonationActionTemplate', data);
    },
    name: 'id'
  }]
});
$(document).on('submit', '#addNewForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#btnSave');
  loadingButton.button('loading');
  $.ajax({
    url: bloodDonationCreateUrl,
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#addModal').modal('hide');
        $('#bloodDonationTable').DataTable().ajax.reload(null, false);
        setTimeout(function () {
          loadingButton.button('reset');
        }, 2500);
      }
    },
    error: function error(result) {
      printErrorMessage('#validationErrorsBox', result);
      setTimeout(function () {
        loadingButton.button('reset');
      }, 2000);
    }
  });
});
$(document).on('submit', '#editForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#btnEditSave');
  loadingButton.button('loading');
  var id = $('#bloodDonationId').val();
  $.ajax({
    url: bloodDonationUrl + '/' + id,
    type: 'post',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#editModal').modal('hide');
        $('#bloodDonationTable').DataTable().ajax.reload(null, false);
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    },
    complete: function complete() {
      loadingButton.button('reset');
      $('#btnSave').attr('disabled', true);
    }
  });
});
$('#addModal').on('hidden.bs.modal', function () {
  $('#donorName').val('').trigger('change.select2');
  resetModalForm('#addNewForm', '#validationErrorsBox');
});
$('#editModal').on('hidden.bs.modal', function () {
  resetModalForm('#editForm', '#editValidationErrorsBox');
});

window.renderData = function (id) {
  $.ajax({
    url: bloodDonationUrl + '/' + id + '/edit',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var bloodDonation = result.data;
        $('#bloodDonationId').val(bloodDonation.id);
        $('#editDonorName').val(bloodDonation.blood_donor_id);
        $('#editDonorName').trigger('change');
        $('#editBags').val(bloodDonation.bags);
        $('#editModal').modal('show');
        ajaxCallCompleted();
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$(document).on('click', '.edit-btn', function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var bloodDonationId = $(event.currentTarget).data('id');
  renderData(bloodDonationId);
});
$(document).on('click', '.delete-btn', function (event) {
  var bloodDonationId = $(event.currentTarget).data('id');
  deleteItem(bloodDonationUrl + '/' + bloodDonationId, '#bloodDonationTable', 'Blood Donation');
});
$(document).ready(function () {
  $('#donorName,#editDonorName').select2({
    width: '100%'
  });
  $('#addModal, #editModal').on('shown.bs.modal', function () {
    $('#donorName, #editDonorName:first').focus();
  });
});

/***/ }),

/***/ 185:
/*!**********************************************************************!*\
  !*** multi ./resources/assets/js/blood_donations/blood_donations.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/blood_donations/blood_donations.js */"./resources/assets/js/blood_donations/blood_donations.js");


/***/ })

/******/ });