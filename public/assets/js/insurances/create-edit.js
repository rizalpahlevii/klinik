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
/******/ 	return __webpack_require__(__webpack_require__.s = 84);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/insurances/create-edit.js":
/*!*******************************************************!*\
  !*** ./resources/assets/js/insurances/create-edit.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  $('.price-input').trigger('input');

  if (discount < 0) {
    $('.discount').val(0);
  }

  $('#discountId').blur(function () {
    if ($('#discountId').val().length == 0) {
      $('#discountId').val(0);
    }
  });
  $('#insuranceForm').find('input:text:visible:first').focus();

  window.isNumberKey = function (evt, element) {
    var charCode = evt.which ? evt.which : event.keyCode;
    return !((charCode !== 46 || $(element).val().indexOf('.') !== -1) && (charCode < 48 || charCode > 57));
  };

  $(document).on('click', '#addItem', function () {
    var data = {
      'uniqueId': uniqueId
    };
    var diseaseItemHtml = prepareTemplateRender('#insuranceDiseaseTemplate', data);
    $('.disease-item-container').append(diseaseItemHtml);
    uniqueId++;
    resetInvoiceItemIndex();
  });
  $(document).on('click', '.delete-disease', function () {
    $(this).parents('tr').remove();
    resetInvoiceItemIndex();
    calculateAndSetInvoiceAmount();
  });

  function resetInvoiceItemIndex() {
    var index = 1;
    $('.disease-item-container>tr').each(function () {
      $(this).find('.item-number').text(index);
      index++;
    });

    if (index - 1 == 0) {
      $('#total').text('0');
      $('#billTbl tbody').append('<tr>' + '<td class="text-center item-number">1</td>' + '<td><input class="form-control disease-name" required name="disease_name[]" type="text"></td>' + '<td><input class="form-control disease-charge price-input" required name="disease_charge[]" type="text"></td>' + '<td class="text-center"><i class="fa fa-trash text-danger delete-disease pointer"></i></td>' + '</tr>');
    }
  }

  $(document).on('change', '.service-tax, .discount, .hospital-rate, .disease-charge', function () {
    calculateAndSetInvoiceAmount();
  });

  window.calculateAndSetInvoiceAmount = function () {
    var totalAmount = 0;
    var serviceTax = parseInt($('.service-tax').val() !== '' ? removeCommas($('.service-tax').val()) : 0);
    var hospitalRate = parseInt($('.hospital-rate').val() !== '' ? removeCommas($('.hospital-rate').val()) : 0);
    var discount = parseFloat($('.discount').val());
    totalAmount = serviceTax + hospitalRate;
    $('.disease-item-container>tr').each(function () {
      var itemTotal = parseInt($(this).find('.disease-charge').val() != '' ? removeCommas($(this).find('.disease-charge').val()) : 0);
      totalAmount += itemTotal;
    });
    totalAmount -= totalAmount * discount / 100;
    $('#total').text(addCommas(totalAmount.toFixed(2)));
    $('#total_amount').val(totalAmount);
  };

  $(document).on('submit', '#insuranceForm', function (event) {
    event.preventDefault();
    screenLock();
    $('#saveBtn').attr('disabled', true);
    var loadingButton = jQuery(this).find('#saveBtn');
    loadingButton.button('loading');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: insuranceSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = insuranceUrl;
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
  });
});

/***/ }),

/***/ 84:
/*!*************************************************************!*\
  !*** multi ./resources/assets/js/insurances/create-edit.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/insurances/create-edit.js */"./resources/assets/js/insurances/create-edit.js");


/***/ })

/******/ });