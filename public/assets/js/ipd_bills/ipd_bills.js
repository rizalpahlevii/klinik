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
/******/ 	return __webpack_require__(__webpack_require__.s = 166);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/ipd_bills/ipd_bills.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/ipd_bills/ipd_bills.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var totalCharges = 0;
var totalPayments = 0;
var grossTotal = 0;
var discountPercent = 0;
var taxPercentage = 0;
var otherCharges = 0;
var netPayabelAmount = 0;
var totalDiscount = 0;
var totalTax = 0;
$(document).ready(function () {
  if (billstaus == 1) {
    $(' #discountPercent, #taxPercentage,#otherCharges ').prop('disabled', true);
  }

  calculateIpdBill();

  if (grossTotal <= 0) {
    $('#grossTotal').text(0);
    $(' #discountPercent, #taxPercentage,#otherCharges ').prop('disabled', true);
  }
});
$(' #discountPercent, #taxPercentage, #otherCharges').on('keyup', function () {
  if (this.id == 'discountPercent' || this.id == 'taxPercentage') {
    if (parseInt(removeCommas($(this).val())) > 100) {
      $(this).val(100);
    }
  }

  calculateIpdBill();
});
$(document).on('submit', '#ipdBillForm', function (e) {
  e.preventDefault();
  $(' #discountPercent, #taxPercentage,#otherCharges').prop('disabled', false);
  screenLock();
  $('#saveIpdBillbtn').attr('disabled', true);
  var loadingButton = jQuery(this).find('#saveIpdBillbtn');
  loadingButton.button('loading');
  calculateIpdBill();
  var formData = new FormData($(this)[0]);
  formData.append('total_charges', totalCharges);
  formData.append('total_payments', totalPayments);
  formData.append('gross_total', grossTotal);
  formData.append('net_payable_amount', netPayabelAmount);
  $.ajax({
    url: ipdBillSaveUrl,
    type: 'POST',
    dataType: 'json',
    data: formData,
    processData: false,
    contentType: false,
    success: function success(result) {
      displaySuccessMessage(result.message);
      window.location.reload();
    },
    error: function error(result) {
      UnprocessableInputError(result);
      $('#saveIpdBillbtn').attr('disabled', false);
    },
    complete: function complete() {
      screenUnLock();
      loadingButton.button('reset');
    }
  });
});

window.calculateIpdBill = function () {
  totalCharges = parseInt(removeCommas($('#totalCharges').text()));
  totalPayments = parseInt(removeCommas($('#totalPayments').text()));
  grossTotal = parseInt(removeCommas($('#grossTotal').text()));
  discountPercent = parseInt(removeCommas($('#discountPercent').val()));
  taxPercentage = parseInt(removeCommas($('#taxPercentage').val()));
  otherCharges = parseInt(removeCommas($('#otherCharges').val()));
  discountPercent = isNaN(discountPercent) ? 0 : discountPercent;
  taxPercentage = isNaN(taxPercentage) ? 0 : taxPercentage;
  otherCharges = isNaN(otherCharges) ? 0 : otherCharges; //calculate

  var total = totalCharges - (totalPayments - otherCharges);
  totalDiscount = percentage(discountPercent, totalCharges);
  totalTax = percentage(taxPercentage, totalCharges);
  netPayabelAmount = totalCharges + otherCharges + totalTax - (totalPayments + totalDiscount);
  if (netPayabelAmount > 0) $('#billStatus').html('UnPaid');else {
    netPayabelAmount = 0;
    $('#billStatus').html('Paid');
  }
  $('#netPayabelAmount').text(addCommas(netPayabelAmount));
};

window.percentage = function (percent, total) {
  return percent / 100 * total;
};

/***/ }),

/***/ 166:
/*!**********************************************************!*\
  !*** multi ./resources/assets/js/ipd_bills/ipd_bills.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/ipd_bills/ipd_bills.js */"./resources/assets/js/ipd_bills/ipd_bills.js");


/***/ })

/******/ });