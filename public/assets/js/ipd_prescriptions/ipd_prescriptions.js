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
/******/ 	return __webpack_require__(__webpack_require__.s = 156);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/ipd_prescriptions/ipd_prescriptions.js":
/*!********************************************************************!*\
  !*** ./resources/assets/js/ipd_prescriptions/ipd_prescriptions.js ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var tableName = '#tblIpdPrescription';
  $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'desc']],
    ajax: {
      url: ipdPrescriptionUrl,
      data: function data(_data) {
        _data.id = ipdPatientDepartmentId;
      }
    },
    columnDefs: [{
      'targets': [2],
      'className': 'text-center',
      'orderable': false,
      'width': '8%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }],
    columns: [{
      data: function data(row) {
        return '<a href="javascript:void(0)" class="viewIpdPrescription" data-pres-id="' + row.id + '">' + row.patient.ipd_number + '</a>';
      },
      name: 'patient.ipd_number'
    }, {
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.created_at === null) {
          return 'N/A';
        }

        return moment(row.created_at).format('Do MMM, Y');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#ipdPrescriptionActionTemplate', data);
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-prescription-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(ipdPrescriptionUrl + '/' + id, tableName, 'IPD Prescription');
  });

  var dropdownToSelect2 = function dropdownToSelect2(selector) {
    $(selector).select2({
      placeholder: 'Select Category',
      width: '100%'
    });
  };

  dropdownToSelect2('.categoryId');

  var medicineSelect2 = function medicineSelect2(selector) {
    $(selector).select2({
      width: '100%'
    });
  };

  $(document).on('click', '#addPrescriptionItem, #addPrescriptionItemOnEdit', function () {
    var itemSelector = parseInt($(this).data('edit')) ? '#editIpdPrescriptionItemTemplate' : '#ipdPrescriptionItemTemplate';
    var tbodyItemSelector = parseInt($(this).data('edit')) ? '.edit-ipd-prescription-item-container' : '.ipd-prescription-item-container';
    var data = {
      'medicineCategories': medicineCategories,
      'uniqueId': uniqueId
    };
    var ipdPrescriptionItemHtml = prepareTemplateRender(itemSelector, data);
    $(tbodyItemSelector).append(ipdPrescriptionItemHtml);
    dropdownToSelect2('.categoryId');
    uniqueId++;
    resetIpdPrescriptionItemIndex(parseInt($(this).data('edit')));
  });

  var resetIpdPrescriptionItemIndex = function resetIpdPrescriptionItemIndex(itemMode) {
    var itemSelector = itemMode ? '#editIpdPrescriptionItemTemplate' : '#ipdPrescriptionItemTemplate';
    var tbodyItemSelector = itemMode ? '.edit-ipd-prescription-item-container' : '.ipd-prescription-item-container';
    var itemNo = itemMode ? '.edit-prescription-item-number' : '.prescription-item-number';
    var index = 1;
    $(tbodyItemSelector + '>tr').each(function () {
      $(this).find(itemNo).text(index);
      index++;
    });

    if (index - 1 == 0) {
      var data = {
        'medicineCategories': medicineCategories,
        'uniqueId': uniqueId
      };
      var ipdPrescriptionItemHtml = prepareTemplateRender(itemSelector, data);
      $(tbodyItemSelector).append(ipdPrescriptionItemHtml);
      dropdownToSelect2('.categoryId');
      uniqueId++;
    }
  };

  $(document).on('click', '.deleteIpdPrescription, .deleteIpdPrescriptionOnEdit', function () {
    $(this).parents('tr').remove();
    resetIpdPrescriptionItemIndex(parseInt($(this).data('edit')));
  });
  $(document).on('change', '.categoryId', function (e, rData) {
    var medicineId = $(document).find('[data-medicine-id=\'' + $(this).data('id') + '\']');

    if ($(this).val() !== '') {
      $.ajax({
        url: medicinesListUrl,
        type: 'get',
        dataType: 'json',
        data: {
          id: $(this).val()
        },
        success: function success(data) {
          if (data.data.length !== 0) {
            medicineId.empty();
            medicineId.removeAttr('disabled');
            medicineSelect2('.medicineId');
            $.each(data.data, function (i, v) {
              medicineId.append($('<option></option>').attr('value', i).text(v));
            });

            if (typeof rData != 'undefined') {
              medicineId.val(rData.medicineId).trigger('change.select2');
            }
          } else {
            medicineId.prop('disabled', true);
          }
        }
      });
    }

    medicineId.empty();
    medicineId.prop('disabled', true);
  });
  $(document).on('submit', '#addIpdPrescriptionForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnIpdPrescriptionSave');
    loadingButton.button('loading');
    var data = {
      'formSelector': $(this),
      'url': ipdPrescriptionCreateUrl,
      'type': 'POST',
      'tableSelector': tableName
    };
    newRecord(data, loadingButton, '#addIpdPrescriptionModal');
  });
  $(document).on('click', '.edit-prescription-btn', function (event) {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var ipdPrescriptionId = $(event.currentTarget).data('id');
    renderPrescriptionData(ipdPrescriptionId);
  });

  window.renderPrescriptionData = function (id) {
    $.ajax({
      url: ipdPrescriptionUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          var ipdPrescriptionData = result.data.ipdPrescription;
          var ipdPrescriptionItemsData = result.data.ipdPrescriptionItems;
          $('#ipdEditPrescriptionId').val(ipdPrescriptionData.id);
          $('#editHeaderNote').val(ipdPrescriptionData.header_note);
          $('#editFooterNote').val(ipdPrescriptionData.footer_note);
          $.each(ipdPrescriptionItemsData, function (i, v) {
            $('#addPrescriptionItemOnEdit').trigger('click');
            var rowId = uniqueId - 1;
            $(document).find('[data-id=\'' + rowId + '\']').val(v.category_id).trigger('change', [{
              medicineId: v.medicine_id
            }]);
            $(document).find('[data-dosage-id=\'' + rowId + '\']').val(v.dosage);
            $(document).find('[data-instruction-id=\'' + rowId + '\']').val(v.instruction);
          });
          var index = 1;
          $('.edit-ipd-prescription-item-container>tr').each(function () {
            $(this).find('.prescription-item-number').text(index);
            index++;
          });
          $('#editIpdPrescriptionModal').modal('show');
          ajaxCallCompleted();
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  };

  $(document).on('submit', '#editIpdPrescriptionForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnEditIpdPrescriptionSave');
    loadingButton.button('loading');
    var id = $('#ipdEditPrescriptionId').val();
    var url = ipdPrescriptionUrl + '/' + id;
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'POST',
      'tableSelector': tableName
    };
    editRecord(data, loadingButton, '#editIpdPrescriptionModal');
  });
  $(document).on('click', '.viewIpdPrescription', function () {
    $.ajax({
      url: ipdPrescriptionUrl + '/' + $(this).data('pres-id'),
      type: 'get',
      beforeSend: function beforeSend() {
        screenLock();
      },
      success: function success(result) {
        $('#ipdPrescriptionViewData').html(result);
        $('#showIpdPrescriptionModal').modal('show');
        ajaxCallCompleted();
      },
      complete: function complete() {
        screenUnLock();
      }
    });
  });
  $(document).on('click', '.printPrescription', function () {
    var divToPrint = document.getElementById('DivIdToPrint');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><link href="' + bootstarpUrl + '" rel="stylesheet" type="text/css"/>' + '<body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();
    setTimeout(function () {
      newWin.close();
    }, 10);
  });
  $('#addIpdPrescriptionModal').on('hidden.bs.modal', function () {
    resetModalForm('#addIpdPrescriptionForm', '#validationErrorsBox');
    $('#ipdPrescriptionTbl').find('tr:gt(1)').remove();
    $('.categoryId').val('');
    $('.categoryId').trigger('change');
  });
  $('#editIpdPrescriptionModal').on('hidden.bs.modal', function () {
    $('#editIpdPrescriptionTbl').find('tr:gt(0)').remove();
  });
});

/***/ }),

/***/ 156:
/*!**************************************************************************!*\
  !*** multi ./resources/assets/js/ipd_prescriptions/ipd_prescriptions.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/ipd_prescriptions/ipd_prescriptions.js */"./resources/assets/js/ipd_prescriptions/ipd_prescriptions.js");


/***/ })

/******/ });