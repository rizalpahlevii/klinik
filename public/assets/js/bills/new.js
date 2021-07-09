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
/******/ 	return __webpack_require__(__webpack_require__.s = 43);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/bills/new.js":
/*!******************************************!*\
  !*** ./resources/assets/js/bills/new.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('input:text:not([readonly="readonly"])').first().blur();
$(document).ready(function () {
  'use strict';

  $('#female,#male').attr('disabled', true);
  $('#patient_id,#patientAdmissionId').select2({
    width: '100%'
  });

  var dropdownToSelect2 = function dropdownToSelect2(selector) {
    $(selector).select2({
      placeholder: 'Select Medicine',
      width: '100%'
    });
  };

  dropdownToSelect2('.accountId');
  var billDateEle = $('#bill_date');
  billDateEle.datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD LT',
    useCurrent: false,
    maxDate: moment()
  }));
  billDateEle.val(billDate);
  $(document).on('click', '#addItem', function () {
    var data = {
      'medicines': associateMedicines,
      'uniqueId': uniqueId
    };
    var invoiceItemHtml = prepareTemplateRender('#billItemTemplate', data);
    $('.bill-item-container').append(invoiceItemHtml);
    dropdownToSelect2('.medicineId');
    uniqueId++;
    resetInvoiceItemIndex();
  });

  var resetInvoiceItemIndex = function resetInvoiceItemIndex() {
    var index = 1;
    $('.bill-item-container>tr').each(function () {
      $(this).find('.item-number').text(index);
      index++;
    });

    if (index - 1 == 0) {
      $('#billTbl tbody').append('<tr>' + '<td class="text-center item-number">1</td>' + '<td class="table__item-desc">' + '<input class="form-control itemName" required name="item_name[]" type="text"></td>' + '<td class="table__qty"><input class="form-control qty quantity" required name="qty[]" type="text"></td>' + '<td><input class="form-control price-input price" required name="price[]" type="text"></td>' + '<td class="amount text-right itemTotal"></td>' + '<td class="text-center"><i class="fa fa-trash text-danger delete-invoice-item pointer"></i></td>' + '</tr>');
    }
  };

  $(document).on('click', '.delete-invoice-item', function () {
    $(this).parents('tr').remove();
    resetInvoiceItemIndex();
    calculateAndSetInvoiceAmount();
  });

  var removeCommas = function removeCommas(str) {
    return str.replace(/,/g, '');
  };

  $(document).on('keyup', '.qty', function () {
    var qty = parseInt($(this).val());
    var rate = $(this).parent().siblings().find('.price').val();
    rate = parseInt(removeCommas(rate));
    var amount = calculateAmount(qty, rate);
    $(this).parent().siblings('.amount').text(addCommas(amount.toString()));
    calculateAndSetInvoiceAmount();
  });
  $(document).on('keyup', '.price', function () {
    var rate = $(this).val();
    rate = parseInt(removeCommas(rate));
    var qty = parseInt($(this).parent().siblings().find('.qty').val());
    var amount = calculateAmount(qty, rate);
    $(this).parent().siblings('.amount').text(addCommas(amount.toString()));
    calculateAndSetInvoiceAmount();
  });

  var calculateAmount = function calculateAmount(qty, rate) {
    if (qty > 0 && rate > 0) {
      return qty * rate;
    } else {
      return 0;
    }
  };

  var calculateAndSetInvoiceAmount = function calculateAndSetInvoiceAmount() {
    var totalAmount = 0;
    $('.bill-item-container>tr').each(function () {
      var itemTotal = $(this).find('.itemTotal').text();
      itemTotal = removeCommas(itemTotal);
      itemTotal = isEmpty($.trim(itemTotal)) ? 0 : parseInt(itemTotal);
      totalAmount += itemTotal;
    });
    totalAmount = parseFloat(totalAmount);
    $('#total').text(addCommas(totalAmount.toFixed(2))); //set hidden input value

    $('#totalAmount').val(totalAmount);
  };

  $(document).on('submit', '#billForm', function (event) {
    event.preventDefault();
    screenLock();
    $('#saveBtn').attr('disabled', true);
    var loadingButton = jQuery(this).find('#saveInvoiceBtn');
    loadingButton.button('loading');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: billSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = billUrl + '/' + result.data.id;
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
        $('#saveBtn').attr('disabled', false);
      },
      complete: function complete() {
        screenUnLock();
        loadingButton.button('reset');
      }
    });
  }); // bill auto fill data script code

  $('#patientAdmissionId').on('change', function () {
    screenLock();
    var data;

    if (isEdit) {
      data = {
        editBillId: billId,
        patient_admission_id: $(this).val()
      };
    } else {
      data = {
        patient_admission_id: $(this).val()
      };
    }

    $.ajax({
      url: patientAdmissionDetailUrl,
      type: 'GET',
      data: data,
      success: function success(result) {
        if (result.success) {
          var patientAdmissionData = result.data;
          $('#pAdmissionId').val($('#patientAdmissionId').find(':selected').val());
          $('#female,#male').attr('disabled', true);
          $('#patientId').val(patientAdmissionData.patientDetails.owner_id);
          $('#name').val(patientAdmissionData.patientDetails.full_name);
          $('#userEmail').val(patientAdmissionData.patientDetails.email);
          $('#userPhone').val(patientAdmissionData.patientDetails.phone != null ? patientAdmissionData.patientDetails.phone : 'N/A');
          if (patientAdmissionData.patientDetails.gender == 1) $('#female').prop('checked', true);else $('#male').prop('checked', true);
          $('#dob').val(patientAdmissionData.patientDetails.dob != null ? patientAdmissionData.patientDetails.dob : 'N/A');
          $('#doctorId').val(patientAdmissionData.doctorName);
          $('#admissionDate').val(patientAdmissionData.admissionDetails.admission_date);
          $('#dischargeDate').val(patientAdmissionData.admissionDetails.discharge_date != null ? patientAdmissionData.admissionDetails.discharge_date : 'N/A');

          if (patientAdmissionData["package"] != '') {
            $('#packageId').val(patientAdmissionData["package"].name != null ? patientAdmissionData["package"].name : 'N/A');
          } else {
            $('#packageId').val('N/A');
          }

          if (patientAdmissionData.admissionDetails.insurance != null) {
            $('#insuranceId').val(patientAdmissionData.admissionDetails.insurance.name);
          } else {
            $('#insuranceId').val('N/A');
          }

          $('#totalDays').val(patientAdmissionData.admissionDetails.totalDays);
          $('#policyNo').val(patientAdmissionData.admissionDetails.policy_no != '' ? patientAdmissionData.admissionDetails.policy_no : 'N/A');

          if (patientAdmissionData["package"] != '' || patientAdmissionData["package"] == '' || !patientAdmissionData.hasOwnProperty('billItems') || patientAdmissionData.hasOwnProperty('billItems') || patientAdmissionData.billItems.length <= 0 || patientAdmissionData.billItems.length >= 0) {
            $('.bill-item-container tr').each(function () {
              var itemRow = $(this).closest('tr');
              itemRow.remove();
            });
            $('#total').text('0');
            $('#billTbl tbody').append('<tr>' + '<td class="text-center item-number">1</td>' + '<td class="table__item-desc">' + '<input class="form-control itemName" required name="item_name[]" type="text"></td>' + '<td class="table__qty"><input class="form-control qty quantity" required name="qty[]" type="text"></td>' + '<td><input class="form-control price-input price" required name="price[]" type="text"></td>' + '<td class="amount text-right itemTotal"></td>' + '<td class="text-center"><i class="fa fa-trash text-danger delete-invoice-item pointer"></i></td>' + '</tr>');
          }

          if (patientAdmissionData["package"] != '' && patientAdmissionData.hasOwnProperty('billItems') && patientAdmissionData.billItems.length > 0) {
            var totalBillItems = patientAdmissionData.billItems.length - 1;
            $('#totalAmount').val(0);
            var total = 0;

            for (var i = 1; i <= totalBillItems; i++) {
              $('#addItem').trigger('click');
            }

            $('.bill-item-container tr').each(function (index) {
              var itemRow = $(this);
              itemRow.find('.itemName').val(patientAdmissionData.billItems[index].item_name);
              itemRow.find('.quantity').val(patientAdmissionData.billItems[index].qty);
              itemRow.find('.price').val(patientAdmissionData.billItems[index].price);
              itemRow.find('.amount').text(patientAdmissionData.billItems[index].amount);
              total = total + parseInt(itemRow.find('.itemTotal').text());
              $('#total').text(total);
            });
            $('#totalAmount').val($('#total').text());
          } else if (patientAdmissionData["package"] != '') {
            if (patientAdmissionData["package"].package_services_items.length > 0) {
              var totalPackageServices = patientAdmissionData["package"].package_services_items.length - 1;
              $('#totalAmount').val(0);
              var _total = 0;

              for (var _i = 1; _i <= totalPackageServices; _i++) {
                $('#addItem').trigger('click');
              }

              $('.bill-item-container tr').each(function (index) {
                var itemRow = $(this);
                itemRow.find('.itemName').val(patientAdmissionData["package"].package_services_items[index].service.name);
                itemRow.find('.quantity').val(patientAdmissionData["package"].package_services_items[index].quantity);
                itemRow.find('.price').val(patientAdmissionData["package"].package_services_items[index].rate);
                itemRow.find('.amount').text(patientAdmissionData["package"].package_services_items[index].amount);
                _total = _total + parseInt(itemRow.find('.itemTotal').text());
                $('#total').text(_total);
              });
              $('#totalAmount').val($('#total').text());
            }
          } else if (patientAdmissionData.hasOwnProperty('billItems') && patientAdmissionData.billItems.length > 0) {
            var _totalBillItems = patientAdmissionData.billItems.length - 1;

            $('#totalAmount').val(0);
            var _total2 = 0;

            for (var _i2 = 1; _i2 <= _totalBillItems; _i2++) {
              $('#addItem').trigger('click');
            }

            $('.bill-item-container tr').each(function (index) {
              var itemRow = $(this);
              itemRow.find('.itemName').val(patientAdmissionData.billItems[index].item_name);
              itemRow.find('.quantity').val(patientAdmissionData.billItems[index].qty);
              itemRow.find('.price').val(patientAdmissionData.billItems[index].price);
              itemRow.find('.amount').text(patientAdmissionData.billItems[index].amount);
              _total2 = _total2 + parseInt(itemRow.find('.itemTotal').text());
              $('#total').text(_total2);
            });
            $('#totalAmount').val($('#total').text());
          }
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      },
      complete: function complete(result) {
        screenUnLock();
      }
    });
  });
});

/***/ }),

/***/ 43:
/*!************************************************!*\
  !*** multi ./resources/assets/js/bills/new.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/bills/new.js */"./resources/assets/js/bills/new.js");


/***/ })

/******/ });