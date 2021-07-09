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
/******/ 	return __webpack_require__(__webpack_require__.s = 130);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/incomes/incomes.js":
/*!************************************************!*\
  !*** ./resources/assets/js/incomes/incomes.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  $('#addModal, #EditModal').on('shown.bs.modal', function () {
    $('#incomeId, #editIncomeHeadId:first').focus();
  });
  $('#incomeId,#editIncomeHeadId,#incomeHead').select2({
    width: '100%'
  });
  $('#date, #editDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: true,
    sideBySide: true
  }));
  var tableName = '#incomeTable';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[3, 'desc']],
    ajax: {
      url: incomeUrl,
      data: function data(_data) {
        _data.income_head = $('#incomeHead').find('option:selected').val();
      }
    },
    columnDefs: [{
      'targets': [0],
      'className': 'text-center',
      'width': '12%'
    }, {
      'targets': [4],
      'className': 'text-right',
      'width': '10%'
    }, {
      'targets': [0, 3],
      'width': '12%'
    }, {
      'targets': [2],
      'width': '22%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }, {
      'targets': [5, 6],
      'orderable': false,
      'className': 'text-center',
      'width': '8%'
    }],
    columns: [{
      data: function data(row) {
        return isEmpty(row.invoice_number) ? 'N/A' : row.invoice_number;
      },
      name: 'invoice_number'
    }, {
      data: function data(row) {
        var showLink = incomeUrl + '/' + row.id;
        return '<a href="' + showLink + '">' + row.name + '</a>';
      },
      name: 'name'
    }, {
      data: function data(row) {
        return incomeHeadArray[row.income_head];
      },
      name: 'income_head'
    }, {
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.date === null) {
          return 'N/A';
        }

        return moment(row.date).format('Do MMM, Y');
      },
      name: 'date'
    }, {
      data: function data(row) {
        return !isEmpty(row.amount) ? '<p class="cur-margin">' + getCurrentCurrencyClass() + ' ' + addCommas(row.amount) + '</p>' : 'N/A';
      },
      name: 'amount'
    }, {
      data: function data(row) {
        if (row.document_url != '') {
          var downloadLink = downloadDocumentUrl + '/' + row.id;
          return '<a href="' + downloadLink + '">' + 'Download' + '</a>';
        } else {
          return 'N/A';
        }
      },
      name: 'id'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#incomeTemplate', data);
      },
      name: 'id'
    }],
    'fnInitComplete': function fnInitComplete() {
      $('#incomeHead').change(function () {
        $(tableName).DataTable().ajax.reload(null, true);
      });
    }
  });
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();
    $('#btnSave').attr('disabled', true);
    var loginButton = jQuery(this).find('#btnSave');
    loginButton.button('loading');
    $.ajax({
      url: incomeCreateUrl,
      type: 'POST',
      data: new FormData(this),
      dataType: 'JSON',
      processData: false,
      contentType: false,
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addModal').modal('hide');
          tbl.ajax.reload(null, false);
        }
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
      },
      complete: function complete() {
        loginButton.button('reset');
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(incomeUrl + '/' + id, tableName, 'Income');
  });
  $(document).on('click', '.edit-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    renderData(id);
  });

  window.renderData = function (id) {
    $.ajax({
      url: incomeUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          var ext = result.data.document_url.split('.').pop().toLowerCase();

          if (ext == 'pdf') {
            $('#editPreviewImage').attr('src', pdfDocumentImageUrl);
          } else if (ext == 'docx' || ext == 'doc') {
            $('#editPreviewImage').attr('src', docxDocumentImageUrl);
          } else if (ext == '') {
            $('#editPreviewImage').attr('src', defaultDocumentImageUrl);
          } else {
            $('#editPreviewImage').attr('src', result.data.document_url);
          }

          $('#editIncomeId').val(result.data.id);
          $('#editIncomeHeadId').val(result.data.income_head).trigger('change.select2');
          $('#editName').val(result.data.name);
          $('#editDate').val(format(result.data.date, 'YYYY-MM-DD'));
          $('#editInvoiceNumber').val(result.data.invoice_number);
          $('#editAmount').val(result.data.amount);
          $('.price-input').trigger('input');
          $('#editDescription').val(result.data.description);

          if (isEmpty(result.data.document_url)) {
            $('#documentUrl').text('');
          } else {
            $('#documentUrl').html('View');
            $('#documentUrl').attr('href', result.data.document_url);
          }

          $('#EditModal').modal('show');
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  };

  $(document).on('submit', '#editForm', function (event) {
    event.preventDefault();
    $('#btnSave').attr('disabled', true);
    var loadingButton = jQuery(this).find('#btnEditSave');
    loadingButton.button('loading');
    var id = $('#editIncomeId').val();
    var url = incomeUrl + '/' + id + '/update';
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'POST',
      'tableSelector': tableName
    };
    editRecord(data, loadingButton);
  });
  $('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#incomeId').val('').trigger('change.select2');
    $('#previewImage').attr('src', defaultDocumentImageUrl);
  });
  $('#EditModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#editValidationErrorsBox');
  });
  $(document).on('change', '#attachment', function () {
    var extension = isValidDocument($(this), '#validationErrorsBox');

    if (!isEmpty(extension) && extension != false) {
      $('#validationErrorsBox').html('').hide();
      displayDocument(this, '#previewImage', extension);
    }
  });
  $(document).on('change', '#editAttachment', function () {
    var extension = isValidDocument($(this), '#editValidationErrorsBox');

    if (!isEmpty(extension) && extension != false) {
      $('#editValidationErrorsBox').html('').hide();
      displayDocument(this, '#editPreviewImage', extension);
    }
  });

  window.isValidDocument = function (inputSelector, validationMessageSelector) {
    var ext = $(inputSelector).val().split('.').pop().toLowerCase();

    if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
      $(inputSelector).val('');
      $(validationMessageSelector).html(documentError).show();
      return false;
    }

    return ext;
  };
});

/***/ }),

/***/ 130:
/*!******************************************************!*\
  !*** multi ./resources/assets/js/incomes/incomes.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/incomes/incomes.js */"./resources/assets/js/incomes/incomes.js");


/***/ })

/******/ });