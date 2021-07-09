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
/******/ 	return __webpack_require__(__webpack_require__.s = 150);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/issued_items/create.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/issued_items/create.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(document).ready(function () {
  $('#itemCategory, #items, #userType, #issueTo').select2({
    width: '100%'
  });
  $('#issueDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: true,
    sideBySide: true
  }));
  $('#returnDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: false,
    sideBySide: true
  }));
  $('#issueDate').on('dp.change', function (e) {
    var minDate = moment($('#issueDate').val()).add(1, 'days');
    $('#returnDate').data('DateTimePicker').minDate(minDate);
  });
  setTimeout(function () {
    $('#itemCategory, #userType').trigger('change');
  }, 300);
});
$('#itemCategory').on('change', function () {
  if ($(this).val() !== '') {
    $.ajax({
      url: itemsUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val()
      },
      success: function success(data) {
        if (data.data.length !== 0) {
          $('#items').empty();
          $('#items').removeAttr('disabled');
          $.each(data.data, function (i, v) {
            $('#items').append($('<option></option>').attr('value', i).text(v));
          });
          $('#items').trigger('change');
        } else {
          $('#items').prop('disabled', true);
          $('#quantity').prop('disabled', true);
          $('#quantity').val('');
          $('#showAvailableQuantity').text('0');
          $('#availableQuantity').val(0);
        }
      }
    });
  }

  $('#items').empty();
  $('#items').prop('disabled', true);
});
$('#userType').on('change', function () {
  if ($(this).val() !== '') {
    $.ajax({
      url: usersUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val()
      },
      success: function success(data) {
        if (data.data.length !== 0) {
          $('#issueTo').empty();
          $('#issueTo').removeAttr('disabled');
          $.each(data.data, function (i, v) {
            $('#issueTo').append($('<option></option>').attr('value', i).text(v));
          });
        } else $('#issueTo').prop('disabled', true);
      }
    });
  }

  $('#issueTo').empty();
  $('#issueTo').prop('disabled', true);
});
$('#items').on('change', function () {
  $.ajax({
    url: itemAvailableQtyUrl,
    type: 'get',
    dataType: 'json',
    data: {
      id: $(this).val()
    },
    success: function success(data) {
      $('#availableQuantity').val(data);
      $('#showAvailableQuantity').text(data);
      $('#quantity').attr('max', data);
      $('#quantity').attr('disabled', false);
    }
  });
});
$('#quantity').on('change', function () {
  var availableQuantity = parseInt($('#availableQuantity').val());
  var quantity = parseInt($(this).val());

  if (quantity <= availableQuantity) {
    $('#btnSave').prop('disabled', false);
  } else if (quantity === 0) showError('Quantity cannot be zero.');else showError('Quantity must be less than Available quantity.');
});

window.showError = function (message) {
  $.toast({
    heading: 'Error',
    text: message,
    showHideTransition: 'fade',
    icon: 'error',
    position: 'top-right'
  });
  $('#btnSave').prop('disabled', true);
};

$(document).on('submit', '#createIssuedItemForm, #editIssuedItemForm', function () {
  $('#btnSave').attr('disabled', true);
});

/***/ }),

/***/ 150:
/*!**********************************************************!*\
  !*** multi ./resources/assets/js/issued_items/create.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/issued_items/create.js */"./resources/assets/js/issued_items/create.js");


/***/ })

/******/ });