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
/******/ 	return __webpack_require__(__webpack_require__.s = 155);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/ipd_charges/ipd_charges.js":
/*!********************************************************!*\
  !*** ./resources/assets/js/ipd_charges/ipd_charges.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var tableName = '#tblIpdCharges';
  $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'desc']],
    ajax: {
      url: ipdChargesUrl,
      data: function data(_data) {
        _data.id = ipdPatientDepartmentId;
      }
    },
    columnDefs: [{
      'targets': [0, 1, 2, 3],
      'width': '15%'
    }, {
      'targets': [4, 5],
      'className': 'text-right',
      'width': '15%'
    }, {
      'targets': [6],
      'className': 'text-center',
      'orderable': false,
      'width': '4%',
      'visible': actionAcoumnVisibal
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }],
    columns: [{
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.date === null) {
          return 'N/A';
        }

        return moment(row.date).format('Do MMM, Y');
      },
      name: 'date'
    }, {
      data: function data(row) {
        if (row.charge_type_id === 1) return 'Procedures';else if (row.charge_type_id === 2) return 'Investigations';else if (row.charge_type_id === 3) return 'Supplier';else if (row.charge_type_id === 4) return 'Operation Theatre';else return 'Others';
      },
      name: 'charge_type_id'
    }, {
      data: 'chargecategory.name',
      name: 'chargecategory.name'
    }, {
      data: 'charge.code',
      name: 'charge.code'
    }, {
      data: function data(row) {
        return !isEmpty(row.standard_charge) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.standard_charge) + '</p>' : 'N/A';
      },
      name: 'standard_charge'
    }, {
      data: function data(row) {
        return !isEmpty(row.applied_charge) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.applied_charge) + '</p>' : 'N/A';
      },
      name: 'applied_charge'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#ipdChargesActionTemplate', data);
      },
      name: 'id'
    }]
  });
  $('#btnIpdChargeSave,#btnEditCharges').prop('disabled', true);
  $('#ipdChargeDate, #ipdEditChargeDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: false,
    sideBySide: true,
    minDate: ipdPatientCaseDate
  }));
  $('#chargeTypeId, #chargeCategoryId, #chargeId, #editChargeTypeId, #editChargeCategoryId, #editChargeId').select2({
    width: '100%'
  });
  $(document).on('click', '.ipdCharegs-delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    var url = ipdChargesUrl + '/' + id;
    var header = 'IPD Charge';
    swal({
      title: 'Delete !',
      text: 'Are you sure want to delete this "' + header + '" ?',
      type: 'warning',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      confirmButtonColor: '#5cb85c',
      cancelButtonColor: '#d33',
      cancelButtonText: 'No',
      confirmButtonText: 'Yes'
    }, function () {
      deleteItemAjax(url, tableName, header);
    });
  });
  $('#chargeTypeId, #editChargeTypeId').on('change', function (e, onceOnEditRender) {
    var isChargeEdit = $(this).data('is-charge-edit');

    if ($(this).val() !== '') {
      $.ajax({
        url: chargeCategoryUrl,
        type: 'get',
        dataType: 'json',
        data: {
          id: $(this).val()
        },
        beforeSend: function beforeSend() {
          makeChargesBtnDisabled(isChargeEdit);
        },
        success: function success(data) {
          if (data.data.length !== 0) {
            $(!isChargeEdit ? '#chargeCategoryId' : '#editChargeCategoryId').empty();
            $(!isChargeEdit ? '#chargeCategoryId' : '#editChargeCategoryId').removeAttr('disabled');
            $.each(data.data, function (i, v) {
              $(!isChargeEdit ? '#chargeCategoryId' : '#editChargeCategoryId').append($('<option></option>').attr('value', i).text(v));
            });
            if (!isChargeEdit) $('#chargeCategoryId').trigger('change');else {
              if (typeof onceOnEditRender == 'undefined') $('#editChargeCategoryId').trigger('change');else {
                $('#editChargeCategoryId').val(editChargeCategoryId).trigger('change', onceOnEditRender);
              }
            }
            $(!isChargeEdit ? '#btnIpdChargeSave' : '#btnEditCharges').prop('disabled', false);
          } else {
            $(!isChargeEdit ? '#chargeCategoryId, #chargeId' : '#editChargeCategoryId, #editChargeId').empty();
            $(!isChargeEdit ? '#ipdStandardCharge, #ipdAppliedCharge' : '#editIpdStandardCharge, #editIpdAppliedCharge').val('');
            $(!isChargeEdit ? '#chargeCategoryId, #chargeId, #btnIpdChargeSave' : '#editChargeCategoryId, #editChargeId, #btnEditCharges').prop('disabled', true);
          }
        }
      });
    }

    $(!isChargeEdit ? '#chargeCategoryId, #chargeId' : '#editChargeCategoryId, #editChargeId').empty();
    $(!isChargeEdit ? '#ipdStandardCharge, #ipdAppliedCharge' : '#editIpdStandardCharge, #editIpdAppliedCharge').val('');
    $(!isChargeEdit ? '#chargeCategoryId, #chargeId' : '#editChargeCategoryId, #editChargeId').prop('disabled', true);
  });
  $('#chargeCategoryId, #editChargeCategoryId').on('change', function (e, onceOnEditRender) {
    var isChargeEdit = $(this).data('is-charge-edit');

    if ($(this).val() !== '') {
      $.ajax({
        url: chargeUrl,
        type: 'get',
        dataType: 'json',
        data: {
          id: $(this).val()
        },
        beforeSend: function beforeSend() {
          makeChargesBtnDisabled(isChargeEdit);
        },
        success: function success(data) {
          if (data.data.length !== 0) {
            $(!isChargeEdit ? '#chargeId' : '#editChargeId').empty();
            $(!isChargeEdit ? '#chargeId' : '#editChargeId').removeAttr('disabled');
            $.each(data.data, function (i, v) {
              $(!isChargeEdit ? '#chargeId' : '#editChargeId').append($('<option></option>').attr('value', i).text(v));
            });
            if (!isChargeEdit) $('#chargeId').trigger('change');else {
              if (typeof onceOnEditRender == 'undefined') $('#editChargeId').trigger('change');else $('#editChargeId').val(editChargeId).trigger('change', onceOnEditRender);
            }
          } else {
            $(!isChargeEdit ? '#chargeId' : '#editChargeId').prop('disabled', true);
          }
        }
      });
    }

    $(!isChargeEdit ? '#chargeId' : '#editChargeId').empty();
    $(!isChargeEdit ? '#chargeId' : '#editChargeId').prop('disabled', true);
  });
  $('#chargeId, #editChargeId').on('change', function (e, onceOnEditRender) {
    var isChargeEdit = $(this).data('is-charge-edit');
    $.ajax({
      url: chargeStandardRateUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val(),
        isEdit: isChargeEdit,
        onceOnEditRender: onceOnEditRender,
        ipdChargeId: $('#ipdChargesId').val()
      },
      beforeSend: function beforeSend() {
        makeChargesBtnDisabled(isChargeEdit);
      },
      success: function success(data) {
        if (!isChargeEdit) {
          $('#ipdStandardCharge, #ipdAppliedCharge').val(data.data);
          $('#btnIpdChargeSave').prop('disabled', false);
        } else {
          if (data.data != null) {
            $('#editIpdStandardCharge').val(data.data.standard_charge);
            $('#editIpdAppliedCharge').val(data.data.applied_charge);
            $('.price-input').trigger('input');
            $('#btnEditCharges').prop('disabled', false);
          }
        }
      }
    });
  });
  $(document).on('submit', '#addIpdChargeNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnIpdChargeSave');
    loadingButton.button('loading');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: ipdChargesCreateUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addIpdChargesModal').modal('hide');
          location.reload();
        }
      },
      error: function error(result) {
        printErrorMessage('#ipdChargevalidationErrorsBox', result);
      },
      complete: function complete() {
        loadingButton.button('reset');
        $('#btnIpdChargeSave').attr('disabled', true);
      }
    });
  });
  $(document).on('click', '.edit-charges-btn', function (event) {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var ipdChargesId = $(event.currentTarget).data('id');
    renderChargesData(ipdChargesId);
  });
  var editChargeCategoryId = null;
  var editChargeId = null;
  var editStandardRate = null;
  var editAppliedCharge = null;

  window.renderChargesData = function (id) {
    $.ajax({
      url: ipdChargesUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          editChargeCategoryId = result.data.charge_category_id;
          editChargeId = result.data.charge_id;
          editStandardRate = result.data.standard_charge;
          editAppliedCharge = result.data.applied_charge;
          $('#ipdChargesId').val(result.data.id);
          $('#ipdEditChargeDate').val(result.data.date);
          $('#editChargeTypeId').val(result.data.charge_type_id).trigger('change', [{
            onceOnEditRender: true
          }]);
          $('.price-input').trigger('input');
          $('#appliedChargeId').text(editAppliedCharge);
          $('#editIpdChargesModal').modal('show');
          ajaxCallCompleted();
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  };

  $(document).on('submit', '#editIpdChargesForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnEditCharges');
    loadingButton.button('loading');
    var id = $('#ipdChargesId').val();
    var url = ipdChargesUrl + '/' + id;
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'POST',
      'tableSelector': tableName
    };
    editRecord(data, loadingButton, '#editIpdChargesModal', '#btnEditCharges');
    location.reload();
  });
  $('#addIpdChargesModal').on('hidden.bs.modal', function () {
    $('#addIpdChargeNewForm')[0].reset();
    $('#chargeTypeId, #chargeCategoryId, #chargeId, #ipdStandardCharge, #ipdAppliedCharge').val('');
    $('#chargeCategoryId, #chargeId').empty();
    $('#chargeTypeId').trigger('change.select2');
    $('#btnIpdChargeSave').prop('disabled', true);
  });
  $('#editIpdChargesModal').on('hidden.bs.modal', function () {
    $('#btnEditCharges').prop('disabled', true);
  });
});

function deleteItemAjax(url, tableId, header) {
  var callFunction = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  $.ajax({
    url: url,
    type: 'DELETE',
    dataType: 'json',
    success: function success(obj) {
      if (obj.success) {
        location.reload();
      }

      swal({
        title: 'Deleted!',
        text: header + ' has been deleted.',
        type: 'success',
        timer: 2000
      });

      if (callFunction) {
        eval(callFunction);
      }
    },
    error: function error(data) {
      swal({
        title: '',
        text: data.responseJSON.message,
        type: 'error',
        timer: 5000
      });
    }
  });
}

window.makeChargesBtnDisabled = function (isChargeOnEdit) {
  $(!isChargeOnEdit ? '#btnIpdChargeSave' : '#btnEditCharges').prop('disabled', true);
};

/***/ }),

/***/ 155:
/*!**************************************************************!*\
  !*** multi ./resources/assets/js/ipd_charges/ipd_charges.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/ipd_charges/ipd_charges.js */"./resources/assets/js/ipd_charges/ipd_charges.js");


/***/ })

/******/ });