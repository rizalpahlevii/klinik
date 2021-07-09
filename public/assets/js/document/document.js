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
/******/ 	return __webpack_require__(__webpack_require__.s = 56);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/document/document.js":
/*!**************************************************!*\
  !*** ./resources/assets/js/document/document.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var tableName = '#tblDocuments';
  $(tableName).DataTable({
    processing: true,
    serverSide: true,
    'order': [[3, 'asc']],
    ajax: {
      url: documentsUrl
    },
    columnDefs: [{
      'targets': [0],
      'className': 'text-center',
      'width': '10%'
    }, {
      'targets': [4],
      'orderable': false,
      'className': 'text-center',
      'width': '6%'
    }, {
      'targets': [0],
      'orderable': false,
      'width': '8%'
    }, {
      targets: '_all',
      defaultContent: 'N/A'
    }],
    columns: [{
      data: function data(row) {
        var downloadLink = downloadDocumentUrl + '/' + row.id;
        return '<a href="' + downloadLink + '">' + 'Download' + '</a>';
      },
      name: 'title'
    }, {
      data: function data(row) {
        var showLink = documentsUrl + '/' + row.id;
        return '<a href="' + showLink + '">' + row.title + '</a>';
      },
      name: 'title'
    }, {
      data: 'document_type.name',
      name: 'documentType.name'
    }, {
      data: 'patient.user.full_name',
      name: 'patient.user.first_name'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id
        }];
        return prepareTemplateRender('#documentsActionTemplate', data);
      },
      name: 'patient.user.last_name'
    }]
  });
  $('#patientId, #documentTypeId, #editPatientId, #editDocumentTypeId').select2({
    width: '100%'
  });
  $(document).on('click', '.delete-btn', function (event) {
    var id = $(event.currentTarget).data('id');
    deleteItem(documentsUrl + '/' + id, tableName, 'Document');
  });
  var filename;
  $('#documentImage').change(function () {
    filename = $(this).val();
  });
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();

    if (filename == null || filename == '') {
      $('#validationErrorsBox').html('Please select attachment').show();
      return false;
    }

    if ($('#validationErrorsBox').text() !== '') {
      $('#documentImage').focus();
      return false;
    }

    var loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');
    var data = {
      'formSelector': $(this),
      'url': documentsCreateUrl,
      'type': 'POST',
      'tableSelector': tableName
    };
    newRecord(data, loadingButton, '#addModal');
  });
  $(document).on('click', '.edit-btn', function (event) {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var documentId = $(event.currentTarget).data('id');
    renderData(documentId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: documentsUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          var ext = result.data.document_url.split('.').pop().toLowerCase();

          if (ext == 'pdf') {
            $('#editPreviewImage').attr('src', pdfDocumentImageUrl);
          } else if (ext == 'docx' || ext == 'doc') {
            $('#editPreviewImage').attr('src', docxDocumentImageUrl);
          } else {
            $('#editPreviewImage').attr('src', result.data.document_url);
          }

          $('#editDocumentTypeId').val(result.data.document_type_id).trigger('change.select2');
          $('#editPatientId').val(result.data.patient_id).trigger('change.select2');
          $('#editTitle').val(result.data.title);
          $('#documentUrl').attr('href', result.data.document_url);
          $('#documentId').val(result.data.id);
          $('#editNotes').val(result.data.notes);
          $('#EditModal').modal('show');
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
    var loadingButton = jQuery(this).find('#btnEditSave');
    loadingButton.button('loading');
    var id = $('#documentId').val();
    var url = documentsUrl + '/' + id + '/update';
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
    $('#previewImage').attr('src', defaultDocumentImageUrl);
  });
  $('#editModal').on('hidden.bs.modal', function () {
    resetModalForm('#editForm', '#validationErrorsBox');
  });
});
$(document).on('change', '#documentImage', function () {
  var extension = isValidDocument($(this), '#validationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    $('#validationErrorsBox').html('').hide();
    displayDocument(this, '#previewImage', extension);
  }
});
$(document).on('change', '#editDocumentImage', function () {
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
    $(validationMessageSelector).html('The document must be a file of type: jpeg, jpg, png, pdf, doc, docx.').show();
    return false;
  }

  return ext;
};

/***/ }),

/***/ 56:
/*!********************************************************!*\
  !*** multi ./resources/assets/js/document/document.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/document/document.js */"./resources/assets/js/document/document.js");


/***/ })

/******/ });