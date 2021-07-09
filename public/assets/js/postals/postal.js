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
/******/ 	return __webpack_require__(__webpack_require__.s = 182);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/postals/postal.js":
/*!***********************************************!*\
  !*** ./resources/assets/js/postals/postal.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  $('#date, #editDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: true,
    sideBySide: true
  }));
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'asc']],
    ajax: {
      url: postalUrl
    },
    columnDefs: [{
      'targets': [3],
      'className': 'text-center',
      'width': '12%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }, {
      'targets': [4, 5],
      'orderable': false,
      'className': 'text-center',
      'width': '8%'
    }],
    columns: [{
      data: function data(row) {
        return ispostal == '2' ? row.to_title : row.from_title;
      },
      name: ispostal == '2' ? 'to_title' : 'from_title'
    }, {
      data: 'reference_no',
      name: 'reference_no'
    }, {
      data: function data(row) {
        return ispostal == '2' ? row.from_title : row.to_title;
      },
      name: ispostal == '2' ? 'from_title' : 'to_title'
    }, {
      data: function data(row) {
        return isEmpty(row.date) ? 'N/A' : row.date;
      },
      name: 'date'
    }, {
      data: function data(row) {
        if (row.document_url != '') {
          var downloadLink = postalUrl + '/' + row.id;
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
        return prepareTemplateRender('#postalTemplate', data);
      },
      name: 'id'
    }]
  });
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();
    $('#btnSave').attr('disabled', true);
    var loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');
    $.ajax({
      url: postalCreateUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
          setTimeout(function () {
            loadingButton.button('reset');
          }, 1000);
        }
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
        setTimeout(function () {
          loadingButton.button('reset');
        }, 1000);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(postalUrl + '/' + id, tableName, name);
  });
  $(document).on('click', '.edit-btn', function (event) {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var postalId = $(event.currentTarget).data('id');
    renderData(postalId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: postalUrl + '/' + id + '/edit',
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

          $(hiddenId).val(result.data.id);
          $('#editFromTitle').val(result.data.from_title);
          $('#editDate').val(result.data.date ? format(result.data.date, 'YYYY-MM-DD') : '');
          $('#editReferenceNumber').val(result.data.reference_no);
          $('#editToTitle').val(result.data.to_title);
          $('#editAddress').val(result.data.address);

          if (isEmpty(result.data.document_url)) {
            $('#documentUrl').text('');
          } else {
            $('#documentUrl').html('View');
            $('#documentUrl').attr('href', result.data.document_url);
          }

          $('#editModal').modal('show');
          ajaxCallCompleted();
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
    var id = $(hiddenId).val();
    var url = postalUrl + '/' + id;
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'post',
      'tableSelector': tableName
    };
    editRecord(data, loadingButton);
    $('#editModal').modal('hide');
  });
  $('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#previewImage').attr('src', defaultDocumentImageUrl);
  });
  $('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '.editValidationErrorsBox');
    $('#previewImage').attr('src', defaultDocumentImageUrl);
  });
  $(document).on('change', '#attachment', function () {
    var extension = isValidDocument($(this), '#validationErrorsBox');

    if (!isEmpty(extension) && extension != false) {
      $('#validationErrorsBox').html('').hide();
      displayDocument(this, '#previewImage', extension);
    }
  });
  $(document).on('change', '#editAttachment', function () {
    var extension = isValidDocument($(this), '#editModal #editValidationErrorsBox');

    if (!isEmpty(extension) && extension != false) {
      displayDocument(this, '#editPreviewImage', extension);
    }
  });

  window.isValidDocument = function (inputSelector, validationMessageSelector) {
    var ext = $(inputSelector).val().split('.').pop().toLowerCase();

    if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
      $(inputSelector).val('');
      $(validationMessageSelector).html(documentError).removeClass('display-none');
      return false;
    }

    $(validationMessageSelector).html(documentError).addClass('display-none');
    return ext;
  };
});

/***/ }),

/***/ 182:
/*!*****************************************************!*\
  !*** multi ./resources/assets/js/postals/postal.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/postals/postal.js */"./resources/assets/js/postals/postal.js");


/***/ })

/******/ });