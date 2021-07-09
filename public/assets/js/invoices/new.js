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
/******/ 	return __webpack_require__(__webpack_require__.s = 89);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/invoices/new.js":
/*!*********************************************!*\
  !*** ./resources/assets/js/invoices/new.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('input:text:not([readonly="readonly"])').first().blur();
$(document).ready(function () {
  'use strict';

  $('#patient_id, #status').select2({
    width: '100%'
  });
  $('#patient_id').focus();

  var dropdownToSelect2 = function dropdownToSelect2(selector) {
    $(selector).select2({
      placeholder: 'Select Account',
      width: '100%'
    });
  };

  dropdownToSelect2('.accountId');
  var invoiceDateEle = $('#invoice_date');
  invoiceDateEle.datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: false,
    maxDate: moment()
  }));
  invoiceDateEle.val(invoiceDate);

  window.isNumberKey = function (evt, element) {
    var charCode = evt.which ? evt.which : event.keyCode;
    return !((charCode !== 46 || $(element).val().indexOf('.') !== -1) && (charCode < 48 || charCode > 57));
  };

  $(document).on('click', '#addItem', function () {
    var data = {
      'accounts': accounts,
      'uniqueId': uniqueId
    };
    var invoiceItemHtml = prepareTemplateRender('#invoiceItemTemplate', data);
    $('.invoice-item-container').append(invoiceItemHtml);
    dropdownToSelect2('.accountId');
    uniqueId++;
    resetInvoiceItemIndex();
  });

  var resetInvoiceItemIndex = function resetInvoiceItemIndex() {
    var index = 1;
    $('.invoice-item-container>tr').each(function () {
      $(this).find('.item-number').text(index);
      index++;
    });

    if (index - 1 == 0) {
      var data = {
        'accounts': accounts,
        'uniqueId': uniqueId
      };
      var invoiceItemHtml = prepareTemplateRender('#invoiceItemTemplate', data);
      $('.invoice-item-container').append(invoiceItemHtml);
      dropdownToSelect2('.accountId');
      uniqueId++;
    }
  };

  $(document).on('click', '.delete-invoice-item', function () {
    $(this).parents('tr').remove();
    resetInvoiceItemIndex();
    calculateAndSetInvoiceAmount();
  });
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
    $('.invoice-item-container>tr').each(function () {
      var itemTotal = $(this).find('.item-total').text();
      itemTotal = removeCommas(itemTotal);
      itemTotal = isEmpty($.trim(itemTotal)) ? 0 : parseInt(itemTotal);
      totalAmount += itemTotal;
    });
    totalAmount = parseFloat(totalAmount);
    $('#total').text(addCommas(totalAmount.toFixed(2))); //set hidden input value

    $('#total_amount').val(totalAmount);
    calculateDiscount();
  };

  var calculateDiscount = function calculateDiscount() {
    var discount = $('#discount').val();
    var totalAmount = removeCommas($('#total').text());

    if (isEmpty(discount) || isEmpty(totalAmount)) {
      discount = 0;
    }

    var discountAmount = totalAmount * discount / 100;
    var finalAmount = totalAmount - discountAmount;
    $('#finalAmount').text(addCommas(finalAmount.toFixed(2)));
    $('#total_amount').val(finalAmount.toFixed(2));
    $('#discountAmount').text(addCommas(discountAmount.toFixed(2)));
  };

  $(document).on('keyup', '#discount', function (e) {
    calculateDiscount();
  });
  $(document).on('submit', '#invoiceForm', function (event) {
    event.preventDefault();
    screenLock();
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: invoiceSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = invoiceUrl + '/' + result.data.id;
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
      },
      complete: function complete() {
        screenUnLock();
      }
    });
  });
});

/***/ }),

/***/ 89:
/*!***************************************************!*\
  !*** multi ./resources/assets/js/invoices/new.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/invoices/new.js */"./resources/assets/js/invoices/new.js");


/***/ })

/******/ });