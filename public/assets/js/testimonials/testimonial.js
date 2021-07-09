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
/******/ 	return __webpack_require__(__webpack_require__.s = 184);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/testimonials/testimonial.js":
/*!*********************************************************!*\
  !*** ./resources/assets/js/testimonials/testimonial.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var tableName = '#testimonialTbl';
var tbl = $('#testimonialTbl').DataTable({
  processing: true,
  serverSide: true,
  'order': [[1, 'asc']],
  ajax: {
    url: testimonialUrl
  },
  columnDefs: [{
    'targets': [0, 3],
    'orderable': false,
    'className': 'text-center',
    'width': '5%'
  }, {
    targets: '_all',
    defaultContent: 'N/A'
  }],
  columns: [{
    data: function data(row) {
      return "<img src=\"".concat(row.document_url, "\" class=\"user-img image-stretching\">");
    },
    name: 'id'
  }, {
    data: 'name',
    name: 'name'
  }, {
    data: 'description',
    name: 'description'
  }, {
    data: function data(row) {
      var data = [{
        'id': row.id
      }];
      return prepareTemplateRender('#testimonialActionTemplate', data);
    },
    name: 'id'
  }]
});
$(document).on('submit', '#addNewForm', function (event) {
  event.preventDefault();
  var loadingButton = jQuery(this).find('#btnSave');
  loadingButton.button('loading');
  var formData = new FormData($(this)[0]);
  $.ajax({
    url: testimonialCreateUrl,
    type: 'POST',
    dataType: 'json',
    data: formData,
    processData: false,
    contentType: false,
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#addModal').modal('hide');
        $(tableName).DataTable().ajax.reload(null, false);
      }
    },
    error: function error(result) {
      printErrorMessage('#validationErrorsBox', result);
    },
    complete: function complete() {
      loadingButton.button('reset');
    }
  });
});
$(document).on('click', '.edit-btn', function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var testimonialId = $(event.currentTarget).data('id');
  renderData(testimonialId);
});

window.renderData = function (id) {
  $.ajax({
    url: testimonialUrl + '/' + id + '/edit',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var ext = result.data.document_url.split('.').pop().toLowerCase();

        if (ext == '') {
          $('#editPreviewImage').attr('src', defaultDocumentImageUrl);
        } else {
          $('#editPreviewImage').attr('src', result.data.document_url);
        }

        $('#testimonialId').val(result.data.id);
        $('#editName').val(result.data.name);
        $('#editDescription').val(result.data.description);

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
  var loadingButton = jQuery(this).find('#btnEditSave');
  loadingButton.button('loading');
  var id = $('#testimonialId').val();
  var formData = new FormData($(this)[0]);
  $.ajax({
    url: testimonialUrl + '/' + id,
    type: 'post',
    data: formData,
    processData: false,
    contentType: false,
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#editModal').modal('hide');
        $(tableName).DataTable().ajax.reload(null, false);
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    },
    complete: function complete() {
      loadingButton.button('reset');
    }
  });
});
$('#addModal').on('hidden.bs.modal', function () {
  resetModalForm('#addNewForm', '#addModal #validationErrorsBox');
  $('#previewImage').attr('src', defaultDocumentImageUrl);
});
$('#addModal').on('shown.bs.modal', function () {
  $('#addModal #validationErrorsBox').show();
  $('#addModal #validationErrorsBox').addClass('d-none');
});
$('#editModal').on('hidden.bs.modal', function () {
  resetModalForm('#editForm', '#editModal #editValidationErrorsBox');
  $('#previewImage').attr('src', defaultDocumentImageUrl);
});
$('#editModal').on('shown.bs.modal', function () {
  $('#editModal #editValidationErrorsBox').show();
  $('#editModal #editValidationErrorsBox').addClass('d-none');
});
$(document).on('click', '.delete-btn', function (event) {
  var testimonialId = $(event.currentTarget).data('id');
  deleteItem(testimonialUrl + '/' + testimonialId, tableName, 'Testimonial');
});
$(document).on('change', '#profile', function () {
  var extension = isValidDocument($(this), '#addModal #validationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    displayDocument(this, '#previewImage', extension);
  }
});
$(document).on('change', '#editProfile', function () {
  var extension = isValidDocument($(this), '#editModal #editValidationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    displayDocument(this, '#editPreviewImage', extension);
  }
});

window.isValidDocument = function (inputSelector, validationMessageSelector) {
  var ext = $(inputSelector).val().split('.').pop().toLowerCase();

  if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
    $(inputSelector).val('');
    $(validationMessageSelector).html(profileError).removeClass('d-none');
    return false;
  }

  $(validationMessageSelector).html(profileError).addClass('d-none');
  return ext;
};

/***/ }),

/***/ 184:
/*!***************************************************************!*\
  !*** multi ./resources/assets/js/testimonials/testimonial.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/testimonials/testimonial.js */"./resources/assets/js/testimonials/testimonial.js");


/***/ })

/******/ });