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
/******/ 	return __webpack_require__(__webpack_require__.s = 180);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/visitors/visitor.js":
/*!*************************************************!*\
  !*** ./resources/assets/js/visitors/visitor.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = '#visitorTbl';
var tbl = $('#visitorTbl').DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'asc']],
  ajax: {
    url: visitorUrl,
    data: function data(_data) {
      _data.purpose = $('#purposeArr').find('option:selected').val();
    }
  },
  columnDefs: [{
    'targets': [9],
    'orderable': false,
    'className': 'text-center',
    'width': '5%'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      if (row.purpose == 1) {
        return 'Visit';
      } else if (row.purpose == 2) {
        return 'Enquiry';
      } else {
        return 'Seminar';
      }
    },
    name: 'purpose'
  }, {
    data: 'name',
    name: 'name'
  }, {
    data: function data(row) {
      return isEmpty(row.phone) ? 'N/A' : row.phone;
    },
    name: 'phone'
  }, {
    data: function data(row) {
      return isEmpty(row.id_card) ? 'N/A' : row.id_card;
    },
    name: 'id_card'
  }, {
    data: function data(row) {
      return isEmpty(row.no_of_person) ? 'N/A' : row.no_of_person;
    },
    name: 'no_of_person'
  }, {
    data: function data(row) {
      return isEmpty(row.date) ? 'N/A' : row.date;
    },
    name: 'date'
  }, {
    data: function data(row) {
      return isEmpty(row.in_time) ? 'N/A' : row.in_time;
    },
    name: 'in_time'
  }, {
    data: function data(row) {
      return isEmpty(row.out_time) ? 'N/A' : row.out_time;
    },
    name: 'out_time'
  }, {
    data: function data(row) {
      if (row.document_url != '') {
        var downloadLink = downloadDocumentUrl + '/' + row.id;
        return '<a href="' + downloadLink + '">' + 'Download' + '</a>';
      }

      return 'N/A';
    },
    name: 'id'
  }, {
    data: function data(row) {
      var url = visitorUrl + row.id;
      var data = [{
        'id': row.id,
        'url': url + '/edit'
      }];
      return prepareTemplateRender('#visitorActionTemplate', data);
    },
    name: 'id'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#purposeArr').change(function () {
      $(tableName).DataTable().ajax.reload(null, true);
    });
  }
});
$(document).on('click', '.delete-btn', function (event) {
  var visitorId = $(event.currentTarget).data('id');
  deleteItem(visitorUrl + visitorId, tableName, 'Visitor');
});
$(document).ready(function () {
  $('#purposeArr').select2({
    width: '100%'
  });
});

/***/ }),

/***/ 180:
/*!*******************************************************!*\
  !*** multi ./resources/assets/js/visitors/visitor.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/visitors/visitor.js */"./resources/assets/js/visitors/visitor.js");


/***/ })

/******/ });