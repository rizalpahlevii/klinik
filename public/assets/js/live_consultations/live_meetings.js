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
/******/ 	return __webpack_require__(__webpack_require__.s = 188);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/live_consultations/live_meetings.js":
/*!*****************************************************************!*\
  !*** ./resources/assets/js/live_consultations/live_meetings.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var tbl = $('#liveMeetingTable').DataTable({
    processing: true,
    serverSide: true,
    'order': [[0, 'desc']],
    ajax: {
      url: liveMeetingUrl
    },
    columnDefs: [{
      targets: '_all',
      defaultContent: 'N/A'
    }, {
      'targets': [3],
      'orderable': false,
      'className': 'text-center',
      'width': '10%'
    }, {
      'targets': [5],
      'orderable': false,
      'className': 'text-center',
      'width': '8%'
    }],
    columns: [{
      data: function data(row) {
        return '<a href="#" class="show-data" data-id="' + row.id + '">' + row.consultation_title + '</a>';
      },
      name: 'consultation_title'
    }, {
      data: function data(row) {
        return row;
      },
      render: function render(row) {
        if (row.consultation_date === null) {
          return 'N/A';
        }

        return moment(row.consultation_date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY hh:mm A');
      },
      name: 'consultation_date'
    }, {
      data: 'user.full_name',
      name: 'user.first_name'
    }, {
      data: function data(row) {
        if (adminRole || doctorRole) {
          return "<select class=\"change-status\" data-id=\"".concat(row.id, "\">") + "<option value=\"0\" ".concat(row.status == 0 ? 'selected' : '', ">Awaited</option>\n                            <option value=\"1\" ").concat(row.status == 1 ? 'selected' : '', ">Cancelled</option>\n                            <option value=\"2\" ").concat(row.status == 2 ? 'selected' : '', ">Finished</option>") + "</select>";
        }

        return row.status_text;
      },
      name: 'status'
    }, {
      data: 'password',
      name: 'password'
    }, {
      data: function data(row) {
        var data = [{
          'id': row.id,
          'status': row.status,
          'url': !(adminRole || doctorRole) ? row.meta.join_url : row.meta.start_url,
          'title': !(adminRole || doctorRole) ? 'Join Meeting' : 'Start Meeting',
          'isDoctor': doctorRole,
          'isAdmin': adminRole,
          'isMeetingFinished': row.status == 2 ? true : false
        }];
        return prepareTemplateRender('#liveMeetingActionTemplate', data);
      },
      name: 'user.last_name'
    }],
    drawCallback: function drawCallback() {
      this.api().state.clear();
      $('.change-status').select2({
        width: '100%'
      });
    }
  });
  $('#userId,.editUserId').select2({
    width: '100%'
  });
  $('.consultation-date, .edit-consultation-date').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD h:mm A',
    useCurrent: true,
    sideBySide: true,
    minDate: new Date()
  }));
  $(document).on('submit', '#addNewForm', function (event) {
    event.preventDefault();
    var loadingButton = jQuery(this).find('#btnSave');
    loadingButton.button('loading');
    $.ajax({
      url: liveMeetingCreateUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addModal').modal('hide');
          $('#liveMeetingTable').DataTable().ajax.reload(null, false);
          setTimeout(function () {
            loadingButton.button('reset');
          }, 2500);
        }
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
        setTimeout(function () {
          loadingButton.button('reset');
        }, 2000);
      }
    });
  });
  $('#addModal').on('hidden.bs.modal', function () {
    resetModalForm('#addNewForm', '#validationErrorsBox');
    $('#userId').val(loggedInUserId).trigger('change.select2');
  });
  $(document).on('change', '.change-status', function () {
    var statusId = $(this).val();
    $.ajax({
      url: liveMeetingUrl + '/change-status',
      type: 'GET',
      data: {
        statusId: statusId,
        id: $(this).data('id')
      },
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#liveMeetingTable').DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        manageAjaxErrors(result);
      }
    });
  });
});
$(document).on('click', '.start-btn', function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var liveConsultationId = $(event.currentTarget).data('id');
  startRenderData(liveConsultationId);
});

window.startRenderData = function (id) {
  $.ajax({
    url: liveMeetingUrl + '/' + id + '/start',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var liveConsultation = result.data;
        $('#startLiveConsultationId').val(liveConsultation.liveMeeting.id);
        $('.start-modal-title').text(liveConsultation.liveMeeting.consultation_title);
        $('.host-name').text(liveConsultation.liveMeeting.user.full_name);
        $('.date').text(liveConsultation.liveMeeting.consultation_date);
        $('.minutes').text(liveConsultation.liveMeeting.consultation_duration_minutes);
        $('#startModal').find('.status').append(liveConsultation.zoomLiveData.data.status === 'started' ? $('.status').text('Started') : $('.status').text('Awaited'));
        !(adminRole || doctorRole) ? $('.start').attr('href', liveConsultation.liveMeeting.meta.join_url) : liveConsultation.zoomLiveData.data.status === 'started' ? $('.start').addClass('disabled') : $('.start').attr('href', liveConsultation.liveMeeting.meta.start_url);
        $('#startModal').modal('show');
        ajaxCallCompleted();
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
};

$(document).on('click', '.show-data', function (event) {
  var meetingId = $(event.currentTarget).data('id');
  $.ajax({
    url: liveMeetingUrl + '/' + meetingId,
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var liveMeeting = result.data;
        $('#showLiveConsultationId').val(liveMeeting.id);
        $('#meetingTitle').text(liveMeeting.consultation_title);
        $('#meetingDate').text(liveMeeting.consultation_date);
        $('#meetingMinutes').text(liveMeeting.consultation_duration_minutes);
        liveMeeting.host_video == 0 ? $('#meetingHost').text('Disable') : $('#meetingHost').text('Enable');
        liveMeeting.participant_video == 0 ? $('#meetingParticipant').text('Disable') : $('#meetingParticipant').text('Enable');
        isEmpty(liveMeeting.description) ? $('#meetingDescription').text('N/A') : $('#meetingDescription').text(liveMeeting.description);
        $('#showModal').modal('show');
      }
    },
    error: function error(result) {
      manageAjaxErrors(result);
    }
  });
});
$(document).on('click', '.edit-btn', function (event) {
  if (ajaxCallIsRunning) {
    return;
  }

  ajaxCallInProgress();
  var liveMeetingId = $(event.currentTarget).data('id');
  renderData(liveMeetingId);
});

window.renderData = function (id) {
  $.ajax({
    url: liveMeetingUrl + '/' + id + '/edit',
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var liveMeeting = result.data;
        $('#liveMeetingId').val(liveMeeting.id);
        $('.edit-consultation-title').val(liveMeeting.consultation_title);
        $('.edit-consultation-date').val(moment(liveMeeting.consultation_date).format('YYYY-MM-DD h:mm A'));
        $('.edit-consultation-duration-minutes').val(liveMeeting.consultation_duration_minutes);
        $('.editUserId').val(liveMeeting.meetingUsers).trigger('change.select2');
        $('.host-enable,.host-disabled').prop('checked', false);

        if (liveMeeting.host_video == 1) {
          $("input[name=\"host_video\"][value=".concat(liveMeeting.host_video, "]")).prop('checked', true);
        } else {
          $("input[name=\"host_video\"][value=".concat(liveMeeting.host_video, "]")).prop('checked', true);
        }

        $('.client-enable,.client-disabled').prop('checked', false);

        if (liveMeeting.participant_video == 1) {
          $("input[name=\"participant_video\"][value=".concat(liveMeeting.participant_video, "]")).prop('checked', true);
        } else {
          $("input[name=\"participant_video\"][value=".concat(liveMeeting.participant_video, "]")).prop('checked', true);
        }

        $('.edit-description').val(liveMeeting.description);
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
  var id = $('#liveMeetingId').val();
  $.ajax({
    url: liveMeetingUrl + '/' + id,
    type: 'post',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#editModal').modal('hide');
        $('#liveMeetingTable').DataTable().ajax.reload(null, false);
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
$(document).on('click', '.delete-btn', function (event) {
  var liveMeetingId = $(event.currentTarget).data('id');
  deleteItem(liveMeetingUrl + '/' + liveMeetingId, '#liveMeetingTable', 'Live Meeting');
});
$('#showModal').on('hidden.bs.modal', function () {
  $(this).find('#meetingTitle,#meetingDate, #meetingMinutes, #meetingHost, #meetingParticipant, #meetingDescription').empty();
});

/***/ }),

/***/ 188:
/*!***********************************************************************!*\
  !*** multi ./resources/assets/js/live_consultations/live_meetings.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/live_consultations/live_meetings.js */"./resources/assets/js/live_consultations/live_meetings.js");


/***/ })

/******/ });