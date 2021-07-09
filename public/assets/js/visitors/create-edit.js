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
/******/ 	return __webpack_require__(__webpack_require__.s = 181);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/visitors/create-edit.js":
/*!*****************************************************!*\
  !*** ./resources/assets/js/visitors/create-edit.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(document).ready(function () {
  $('#createVisitorForm, #editVisitorForm').submit(function () {
    if ($('#error-msg').text() !== '') {
      $('#phoneNumber').focus();
      return false;
    }
  });
  $('#createVisitorForm, #editVisitorForm').on('keyup keypress', function (e) {
    var keyCode = e.keyCode || e.which;

    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });
  $('#date').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: true,
    sideBySide: true
  }));
  $('#inTime,#outTime').datetimepicker(DatetimepickerDefaults({
    format: 'HH:mm:ss',
    useCurrent: true,
    sideBySide: true,
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
    }
  }));
  $('#outTime').datetimepicker(DatetimepickerDefaults({
    format: 'HH:mm:ss',
    useCurrent: true,
    sideBySide: true,
    minDate: moment(new Date()).format('HH:mm:ss')
  }));
  $('#inTime').on('dp.change', function (e) {
    $('#outTime').data('DateTimePicker').minDate(e.date);
  });
  $(document).ready(function () {
    $('#purpose').select2({
      width: '100%'
    });
  });
  $(document).on('change', '#attachment', function () {
    var extension = isValidDocument($(this), '#visitorValidationErrorsBox');

    if (!isEmpty(extension) && extension != false) {
      $('#validationErrorsBox').html('').hide();
      displayDocument(this, '#previewImage', extension);
    }
  });

  window.isValidDocument = function (inputSelector, validationMessageSelector) {
    var ext = $(inputSelector).val().split('.').pop().toLowerCase();

    if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
      $(inputSelector).val('');
      $(validationMessageSelector).html('The document must be a file of type: jpeg, jpg, png, pdf, doc, docx.').removeClass('display-none');
      return false;
    }

    $(validationMessageSelector).addClass('display-none');
    return ext;
  };

  $(document).on('submit', '#createVisitorForm, #editVisitorForm', function () {
    $('#btnSave').attr('disabled', true);
  });
});

/***/ }),

/***/ 181:
/*!***********************************************************!*\
  !*** multi ./resources/assets/js/visitors/create-edit.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/visitors/create-edit.js */"./resources/assets/js/visitors/create-edit.js");


/***/ })

/******/ });