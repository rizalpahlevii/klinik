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
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/departments/departments.js":
/*!********************************************************!*\
  !*** ./resources/assets/js/departments/departments.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = '#departments-table';
$(tableName).DataTable({
  processing: true,
  serverSide: true,
  'order': [[0, 'asc']],
  ajax: {
    url: departmentUrl,
    data: function data(_data) {
      _data.is_active = $('#filter_active').find('option:selected').val();
    }
  },
  columnDefs: [{
    'targets': [1, 2],
    'orderable': false,
    'className': 'text-center',
    'width': '6%'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: 'name',
    name: 'name'
  }, {
    data: function data(row) {
      var checked = row.is_active == 0 ? '' : 'checked';
      var data = [{
        "id": row.id,
        "checked": checked
      }];
      return prepareTemplateRender("#departmentIsActiveTemplate", data);
    },
    name: 'is_active'
  }, {
    data: function data(row) {
      var data = [{
        "id": row.id
      }];
      return prepareTemplateRender("#departmentActionTemplate", data);
    },
    name: 'id'
  }],
  'fnInitComplete': function fnInitComplete() {
    $('#filter_active').change(function () {
      $(tableName).DataTable().ajax.reload(null, false);
      $(tableName).DataTable().page('previous').draw('page');
    });
  }
});
$(document).on('change', '.is-active', function (event) {
  var departmentId = $(event.currentTarget).data('id');
  updateStatus(departmentId);
});

window.updateStatus = function (id) {
  $.ajax({
    url: departmentUrl + id + '/active-deactive',
    method: 'post',
    cache: false,
    success: function success(result) {
      if (result.success) {
        $(tableName).DataTable().ajax.reload(null, false);
      }
    }
  });
};

$(document).on('submit', '#addNewForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find("#btnSave");
  loadingButton.button('loading');
  var data = {
    'formSelector': $(this),
    'url': departmentCreateUrl,
    'type': 'POST',
    'tableSelector': tableName
  };
  newRecord(data, loadingButton);
});
$(document).on('submit', '#editForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find("#btnEditSave");
  loadingButton.button('loading');
  var id = $('#departmentId').val();
  var url = departmentUrl + id;
  var data = {
    'formSelector': $(this),
    'url': url,
    'type': 'PUT',
    'tableSelector': tableName
  };
  editRecordWithForm(data, loadingButton);
});
$(document).on('click', '.edit-btn', function (event) {
  var departmentId = $(event.currentTarget).data('id');
  renderData(departmentId);
});
$(document).on('click', '.delete-btn', function (event) {
  var id = $(event.currentTarget).data('id');
  deleteItem(departmentUrl + id, tableName, 'Department');
});

window.renderData = function (id) {
  $.ajax({
    url: departmentUrl + id + '/edit',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        $('#departmentId').val(result.data.id);
        $('#editName').val(result.data.name);

        if (result.data.is_active) {
          $('#editIsActive').val(1).prop('checked', true);
        }

        $('#EditModal').modal('show');
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$('#filter_active').select2({
  width: '100%'
});

/***/ }),

/***/ 7:
/*!**************************************************************!*\
  !*** multi ./resources/assets/js/departments/departments.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/departments/departments.js */"./resources/assets/js/departments/departments.js");


/***/ })

/******/ });