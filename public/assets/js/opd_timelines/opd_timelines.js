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
/******/ 	return __webpack_require__(__webpack_require__.s = 172);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/opd_timelines/opd_timelines.js":
/*!************************************************************!*\
  !*** ./resources/assets/js/opd_timelines/opd_timelines.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  getOpdTimelines($('#opdPatientDepartmentId').val());
  $('#timelineDate, #editTimelineDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    useCurrent: true,
    sideBySide: true,
    minDate: moment(appointmentDate).format('YYYY-MM-DD')
  }));
  $(document).on('submit', '#addOpdTimelineNewForm', function (e) {
    e.preventDefault();
    var loadingButton = jQuery(this).find('#btnOpdTimelineSave');
    loadingButton.button('loading');
    var data = {
      'formSelector': $(this),
      'url': opdTimelineCreateUrl,
      'type': 'POST',
      'tableSelector': '#tbl'
    };
    newRecord(data, loadingButton, '#addOpdTimelineModal');
    setTimeout(function () {
      getOpdTimelines($('#opdPatientDepartmentId').val());
    }, 500);
  });
  $(document).on('click', '.edit-timeline-btn', function () {
    if (ajaxCallIsRunning) {
      return;
    }

    ajaxCallInProgress();
    var opdTimelineId = $(this).data('timeline-id');
    renderTimelineData(opdTimelineId);
  });

  window.renderTimelineData = function (id) {
    $.ajax({
      url: opdTimelinesUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          if (result.data.opd_timeline_document_url != '') {
            var ext = result.data.opd_timeline_document_url.split('.').pop().toLowerCase();

            if (ext == 'pdf') {
              $('#editPreviewTimelineImage').attr('src', pdfDocumentImageUrl);
            } else if (ext == 'docx' || ext == 'doc') {
              $('#editPreviewTimelineImage').attr('src', docxDocumentImageUrl);
            } else {
              $('#editPreviewTimelineImage').attr('src', result.data.opd_timeline_document_url);
            }

            $('#timeDocumentUrl').show();
          } else {
            $('#timeDocumentUrl').hide();
            $('#editPreviewTimelineImage').attr('src', defaultDocumentImageUrl);
          }

          $('#opdTimelineId').val(result.data.id);
          $('#editTimelineTitle').val(result.data.title);
          $('#editTimelineDate').val(result.data.date);
          $('#editTimelineDescription').val(result.data.description);
          $('#timeDocumentUrl').attr('href', result.data.opd_timeline_document_url);
          result.data.visible_to_person == 1 ? $('#editTimelineVisibleToPerson').prop('checked', true) : $('#editTimelineVisibleToPerson').prop('checked', false);
          $('#editOpdTimelineModal').modal('show');
          ajaxCallCompleted();
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  };

  $(document).on('submit', '#editOpdTimelineForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnOpdTimelineEdit');
    loadingButton.button('loading');
    var id = $('#opdTimelineId').val();
    var url = opdTimelinesUrl + '/' + id;
    var data = {
      'formSelector': $(this),
      'url': url,
      'type': 'POST',
      'tableSelector': '#tbl'
    };
    editRecord(data, loadingButton, '#editOpdTimelineModal');
    setTimeout(function () {
      location.reload();
    }, 500);
  });
  $(document).on('click', '.delete-timeline-btn', function () {
    var id = $(this).data('timeline-id');
    deleteOpdTimelineItem(opdTimelinesUrl + '/' + id, 'OPD Timeline');
  });

  window.deleteOpdTimelineItem = function (url, header) {
    swal({
      title: 'Delete !',
      text: 'Are you sure want to delete this "' + header + '" ?',
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
        url: url,
        type: 'DELETE',
        dataType: 'json',
        success: function success(obj) {
          if (obj.success) {
            setTimeout(function () {
              getOpdTimelines($('#opdPatientDepartmentId').val());
            }, 500);
          }

          swal({
            title: 'Deleted!',
            text: header + ' has been deleted.',
            type: 'success',
            timer: 2000
          });
        },
        error: function error(data) {
          swal({
            title: '',
            text: data.responseJSON.message,
            type: 'error',
            timer: 5000
          });
        }
      });
    });
  };

  $('#addOpdTimelineModal').on('hidden.bs.modal', function () {
    resetModalForm('#addOpdTimelineNewForm', '#timeLinevalidationErrorsBox');
    $('#previewTimelineImage').attr('src', defaultDocumentImageUrl);
  });
  $('#editOpdTimelineModal').on('hidden.bs.modal', function () {
    resetModalForm('#editOpdTimelineForm', '#editTimelineValidationErrorsBox');
  });
});
$(document).on('change', '#timelineDocumentImage', function () {
  var extension = isValidTimelineDocument($(this), '#timeLinevalidationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    $('#timeLinevalidationErrorsBox').html('').hide();
    displayDocument(this, '#previewTimelineImage', extension);
  }
});
$(document).on('change', '#editTimelineDocumentImage', function () {
  var extension = isValidTimelineDocument($(this), '#editTimelineValidationErrorsBox');

  if (!isEmpty(extension) && extension != false) {
    $('#editTimelineValidationErrorsBox').html('').hide();
    displayDocument(this, '#editPreviewTimelineImage', extension);
  }
});

window.isValidTimelineDocument = function (inputSelector, validationMessageSelector) {
  var ext = $(inputSelector).val().split('.').pop().toLowerCase();

  if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx']) == -1) {
    $(inputSelector).val('');
    $(validationMessageSelector).html('The document must be a file of type: jpeg, jpg, png, pdf, doc, docx.').show();
    return false;
  }

  return ext;
};

window.getOpdTimelines = function (opdPatientDepartmentId) {
  $.ajax({
    url: opdTimelinesUrl,
    type: 'get',
    data: {
      id: opdPatientDepartmentId
    },
    success: function success(data) {
      $('#opdTimelines').html(data);
    }
  });
};

/***/ }),

/***/ 172:
/*!******************************************************************!*\
  !*** multi ./resources/assets/js/opd_timelines/opd_timelines.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/opd_timelines/opd_timelines.js */"./resources/assets/js/opd_timelines/opd_timelines.js");


/***/ })

/******/ });