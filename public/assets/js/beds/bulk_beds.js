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
/******/ 	return __webpack_require__(__webpack_require__.s = 51);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/beds/bulk_beds.js":
/*!***********************************************!*\
  !*** ./resources/assets/js/beds/bulk_beds.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var dropdownToSelect2 = function dropdownToSelect2(selector) {
    $(selector).select2({
      placeholder: 'Select Bed Type',
      width: '100%'
    });
  };

  $(document).on('click', '#addItem', function () {
    var data = {
      'bedTypes': bedTypes,
      'uniqueId': uniqueId
    };
    var bulkBedItemHtml = prepareTemplateRender('#bulkBedActionTemplate', data);
    $('.bulk-beds-item-container').append(bulkBedItemHtml);
    dropdownToSelect2('.bedType');
    uniqueId++;
    resetBulkBedItemIndex();
  });

  var resetBulkBedItemIndex = function resetBulkBedItemIndex() {
    var index = 1;
    $('.bulk-beds-item-container>tr').each(function () {
      $(this).find('.item-number').text(index);
      index++;
    });

    if (index - 1 == 0) {
      var data = {
        'services': bedTypes,
        'uniqueId': uniqueId
      };
      var bulkBedItemHtml = prepareTemplateRender('#bulkBedActionTemplate', data);
      $('.bulk-beds-item-container').append(bulkBedItemHtml);
      dropdownToSelect2('.bedType');
      uniqueId++;
    }
  };

  $(document).on('click', '.delete-invoice-item', function () {
    $(this).parents('tr').remove();
    resetBulkBedItemIndex();
  });
  $(document).on('submit', '#bulkBedsForm', function (event) {
    event.preventDefault();
    screenLock();
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: bulkBedSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = bedUrl;
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

/***/ 51:
/*!*****************************************************!*\
  !*** multi ./resources/assets/js/beds/bulk_beds.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/beds/bulk_beds.js */"./resources/assets/js/beds/bulk_beds.js");


/***/ })

/******/ });