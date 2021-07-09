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
/******/ 	return __webpack_require__(__webpack_require__.s = 149);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/issued_items/issued_items.js":
/*!**********************************************************!*\
  !*** ./resources/assets/js/issued_items/issued_items.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$('#filter_status').select2();
var tbl = $('#issuedItemsTable').DataTable({
  processing: true,
  serverSide: true,
  'order': [[2, 'desc']],
  ajax: {
    url: issuedItemUrl,
    data: function data(_data) {
      _data.status = $('#filter_status').find('option:selected').val();
    }
  },
  columnDefs: [{
    'targets': [5, 6],
    'orderable': false,
    'className': 'text-center',
    'width': '10%'
  }, {
    'targets': [4],
    'className': 'text-right'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      var showLink = issuedItemUrl + '/' + row.id;
      return '<a href="' + showLink + '">' + row.item.name + '</a>';
    },
    name: 'item.name'
  }, {
    data: 'item.itemcategory.name',
    name: 'item.itemcategory.name'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      return moment(row.issued_date).utc().format('Do MMM, Y');
    },
    name: 'issued_date'
  }, {
    data: function data(row) {
      return row;
    },
    render: function render(row) {
      if (row.return_date === null) {
        return 'N/A';
      }

      return moment(row.return_date).utc().format('Do MMM, Y');
    },
    name: 'return_date'
  }, {
    data: 'quantity',
    name: 'quantity'
  }, {
    data: function data(row) {
      var statusText = row.status == 0 ? 'Return Item' : 'Returned';
      var statusBadge = row.status == 0 ? 'info' : 'primary';
      var data = [{
        'id': row.id,
        'status': row.status,
        'statusText': statusText,
        'statusBadge': statusBadge
      }];
      return prepareTemplateRender('#issuedItemStatusTemplate', data);
    },
    name: 'status'
  }, {
    data: function data(row) {
      var url = issuedItemUrl + '/' + row.id;
      var data = [{
        'id': row.id,
        'url': url + '/edit'
      }];
      return prepareTemplateRender('#issuedItemActionTemplate', data);
    },
    name: 'id'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#filter_status').change(function () {
      $('#issuedItemsTable').DataTable().ajax.reload(null, true);
    });
  }
});
$(document).on('click', '.delete-btn', function (event) {
  var issuedItemId = $(event.currentTarget).data('id');
  deleteItem(issuedItemUrl + '/' + issuedItemId, '#issuedItemsTable', 'Issued Item');
});
$(document).on('click', '.changes-status-btn', function (event) {
  var issuedItemId = $(this).data('id');
  var issuedItemStatus = $(this).data('status');

  if (!issuedItemStatus) {
    swal({
      title: 'Return Item !',
      text: 'Are you sure want to return this item ?',
      type: 'warning',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      confirmButtonColor: '#5cb85c',
      cancelButtonColor: '#d33',
      cancelButtonText: 'No',
      confirmButtonText: 'Yes'
    }, function () {
      $.ajax({
        url: returnIssuedItemUrl,
        type: 'get',
        dataType: 'json',
        data: {
          id: issuedItemId
        },
        success: function success(data) {
          swal({
            title: 'Item Returned!',
            text: data.message,
            type: 'success',
            timer: 2000
          });
          tbl.ajax.reload(null, true);
        }
      });
    });
  }
});

/***/ }),

/***/ 149:
/*!****************************************************************!*\
  !*** multi ./resources/assets/js/issued_items/issued_items.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/issued_items/issued_items.js */"./resources/assets/js/issued_items/issued_items.js");


/***/ })

/******/ });