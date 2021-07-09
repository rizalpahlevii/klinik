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
/******/ 	return __webpack_require__(__webpack_require__.s = 83);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/insurances/insurances.js":
/*!******************************************************!*\
  !*** ./resources/assets/js/insurances/insurances.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = '#insurancesTbl';
var tbl = $('#insurancesTbl').DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'asc']],
  ajax: {
    url: insuranceUrl,
    data: function data(_data) {
      _data.status = $('#filter_status').find('option:selected').val();
    }
  },
  columnDefs: [{
    targets: '_all',
    defaultContent: 'N/A'
  }, {
    'targets': [1, 4, 5],
    'className': 'text-right'
  }, {
    'targets': [6, 7],
    'orderable': false,
    'className': 'text-center',
    'width': '5%'
  }],
  columns: [{
    data: function data(row) {
      var showLink = insuranceUrl + '/' + row.id;
      return '<a href="' + showLink + '">' + row.name + '</a>';
    },
    name: 'name'
  }, {
    data: function data(row) {
      return !isEmpty(row.service_tax) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.service_tax) + '</p>' : 'N/A';
    },
    name: 'service_tax'
  }, {
    data: 'insurance_no',
    name: 'insurance_no'
  }, {
    data: 'insurance_code',
    name: 'insurance_code'
  }, {
    data: function data(row) {
      return !isEmpty(row.hospital_rate) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.hospital_rate) + '</p>' : 'N/A';
    },
    name: 'hospital_rate'
  }, {
    data: function data(row) {
      return !isEmpty(row.total) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.total) + '</p>' : 'N/A';
    },
    name: 'total'
  }, {
    data: function data(row) {
      var checked = row.status == 0 ? '' : 'checked';
      var data = [{
        'id': row.id,
        'checked': checked
      }];
      return prepareTemplateRender('#insuranceStatusTemplate', data);
    },
    name: 'status'
  }, {
    data: function data(row) {
      var url = insuranceUrl + '/' + row.id;
      var data = [{
        'id': row.id,
        'url': url + '/edit'
      }];
      return prepareTemplateRender('#insuranceActionTemplate', data);
    },
    name: 'id'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#filter_status').change(function () {
      $(tableName).DataTable().ajax.reload(null, true);
    });
  }
});
$(document).on('click', '.delete-btn', function (event) {
  var insuranceId = $(event.currentTarget).data('id');
  deleteItem(insuranceUrl + '/' + insuranceId, '#insurancesTbl', 'Insurance');
});
$(document).on('change', '.status', function (event) {
  var insuranceId = $(event.currentTarget).data('id');
  updateStatus(insuranceId);
});

window.updateStatus = function (id) {
  $.ajax({
    url: insuranceUrl + '/' + id + '/active-deactive',
    method: 'post',
    cache: false,
    success: function success(result) {
      if (result.success) {
        tbl.ajax.reload(null, false);
      }
    }
  });
};

/***/ }),

/***/ 83:
/*!************************************************************!*\
  !*** multi ./resources/assets/js/insurances/insurances.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/insurances/insurances.js */"./resources/assets/js/insurances/insurances.js");


/***/ })

/******/ });