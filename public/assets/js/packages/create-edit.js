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
/******/ 	return __webpack_require__(__webpack_require__.s = 95);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/packages/create-edit.js":
/*!*****************************************************!*\
  !*** ./resources/assets/js/packages/create-edit.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var dropdownToSelecte2 = function dropdownToSelecte2(selector) {
    $(selector).select2({
      placeholder: 'Select Service',
      width: '100%'
    });
  };

  $('#packageForm').find('input:text:visible:first').focus();
  dropdownToSelecte2('.serviceId');
  $(document).on('click', '#addItem', function () {
    var data = {
      'services': associateServices,
      'uniqueId': uniqueId
    };
    var packageServiceItemHtml = prepareTemplateRender('#packageServiceTemplate', data);
    $('.package-service-item-container').append(packageServiceItemHtml);
    dropdownToSelecte2('.serviceId');
    uniqueId++;
    resetServicePackageItemIndex();
  });

  var resetServicePackageItemIndex = function resetServicePackageItemIndex() {
    var index = 1;
    $('.package-service-item-container>tr').each(function () {
      $(this).find('.item-number').text(index);
      index++;
    });

    if (index - 1 == 0) {
      var data = {
        'services': associateServices,
        'uniqueId': uniqueId
      };
      var packageServiceItemHtml = prepareTemplateRender('#packageServiceTemplate', data);
      $('.package-service-item-container').append(packageServiceItemHtml);
      dropdownToSelecte2('.serviceId');
      uniqueId++;
    }
  };

  $(document).on('click', '.delete-service-package-item', function () {
    $(this).parents('tr').remove();
    resetServicePackageItemIndex();
    calculateAndSetTotalAmount();
  });

  var removeCommas = function removeCommas(str) {
    return str.replace(/,/g, '');
  };

  window.isNumberKey = function (evt, element) {
    var charCode = evt.which ? evt.which : event.keyCode;
    return !((charCode !== 46 || $(element).val().indexOf('.') !== -1) && (charCode < 48 || charCode > 57));
  };

  $(document).on('keyup', '.qty', function () {
    var qty = parseInt($(this).val());
    var rate = $(this).parent().siblings().find('.price').val();
    rate = parseInt(removeCommas(rate));
    var amount = calculateAmount(qty, rate);
    $(this).parent().siblings('.amount').text(addCommas(amount.toString()));
    calculateAndSetTotalAmount();
  });
  $(document).on('keyup', '.price', function () {
    var rate = $(this).val();
    rate = parseInt(removeCommas(rate));
    var qty = parseInt($(this).parent().siblings().find('.qty').val());
    var amount = calculateAmount(qty, rate);
    $(this).parent().siblings('.amount').text(addCommas(amount.toString()));
    calculateAndSetTotalAmount();
  });
  $(document).on('keyup', '.discount', function () {
    calculateAndSetTotalAmount();
  });

  var calculateAmount = function calculateAmount(qty, rate) {
    if (qty > 0 && rate > 0) {
      return qty * rate;
    } else {
      return 0;
    }
  };

  var calculateAndSetTotalAmount = function calculateAndSetTotalAmount() {
    var totalAmount = 0;
    var discount = parseFloat($('.discount').val() !== '' ? $('.discount').val() : 0);
    $('.package-service-item-container>tr').each(function () {
      var itemTotal = $(this).find('.item-total').text();
      itemTotal = removeCommas(itemTotal);
      itemTotal = isEmpty($.trim(itemTotal)) ? 0 : parseInt(itemTotal);
      totalAmount += itemTotal;
    });
    totalAmount = parseFloat(totalAmount);
    totalAmount -= totalAmount * discount / 100;
    $('#total').text(addCommas(totalAmount.toFixed(2))); //set hidden input value

    $('#total_amount').val(totalAmount);
  };

  $(document).on('submit', '#packageForm', function (event) {
    event.preventDefault();
    screenLock();
    $('#saveBtn').attr('disabled', true);
    var loadingButton = jQuery(this).find('#saveBtn');
    loadingButton.button('loading');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: packageSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = packageUrl;
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

/***/ 95:
/*!***********************************************************!*\
  !*** multi ./resources/assets/js/packages/create-edit.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/packages/create-edit.js */"./resources/assets/js/packages/create-edit.js");


/***/ })

/******/ });