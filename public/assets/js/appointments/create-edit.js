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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/appointments/create-edit.js":
/*!*********************************************************!*\
  !*** ./resources/assets/js/appointments/create-edit.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  $('#patientId, #doctorId, #departmentId').select2({
    width: '100%'
  });
  $('#opdDate').datetimepicker(DatetimepickerDefaults({
    format: 'YYYY-MM-DD',
    sideBySide: true,
    minDate: moment().subtract(1, 'days'),
    useCurrent: false
  }));
  $('#patientId').first().focus();
  $('#departmentId').on('change', function () {
    $('.error-message').css('display', 'none');
    $('#opdDate').data('DateTimePicker').clear();
    $.ajax({
      url: doctorDepartmentUrl,
      type: 'get',
      dataType: 'json',
      data: {
        id: $(this).val()
      },
      success: function success(data) {
        $('#doctorId').empty();
        $('#doctorId').append($('<option value="">Select Doctor</option>'));
        $.each(data.data, function (i, v) {
          $('#doctorId').append($('<option></option>').attr('value', i).text(v));
        });
      }
    });
  });
  var doctorId;
  var doctorChange = false;
  $('#doctorId').on('change', function () {
    if (doctorChange) {
      $('.error-message').css('display', 'none');
      $('#opdDate').data('DateTimePicker').clear();
      doctorChange = true;
    }

    $('.error-message').css('display', 'none');
    doctorId = $(this).val();
    doctorChange = true;
  });
  var selectedDate;
  var intervals;
  var alreadyCreateTimeSlot;
  $('#opdDate').on('dp.change', function () {
    $('.doctor-schedule').css('display', 'none');
    $('.error-message').css('display', 'none');
    $('.available-slot-heading').css('display', 'none');
    $('.color-information').css('display', 'none');
    $('.time-slot').remove();

    if ($('#departmentId').val() == '') {
      $('#validationErrorsBox').show().html('Please select Doctor Department');
      $('#validationErrorsBox').delay(5000).fadeOut();
      $('#opdDate').val('');
      $('#opdDate').data('DateTimePicker').clear();
      return false;
    } else if ($('#doctorId').val() == '') {
      $('#validationErrorsBox').show().html('Please select Doctor');
      $('#validationErrorsBox').delay(5000).fadeOut();
      $('#opdDate').val('');
      $('#opdDate').data('DateTimePicker').clear();
      return false;
    }

    var weekday = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var selected = new Date($(this).val());
    var dayName = weekday[selected.getDay()];
    selectedDate = $(this).val(); //if dayName is blank, then ajax call not run.

    if (dayName == null || dayName == '') {
      return false;
    } //get doctor schedule list with time slot.


    $.ajax({
      type: 'GET',
      url: doctorScheduleList,
      data: {
        day_name: dayName,
        doctor_id: doctorId
      },
      success: function success(result) {
        if (result.success) {
          if (result.data != '') {
            if (result.data.scheduleDay.length != 0) {
              var doctorStartTime = selectedDate + ' ' + result.data.scheduleDay[0].available_from;
              var doctorEndTime = selectedDate + ' ' + result.data.scheduleDay[0].available_to;
              var doctorPatientTime = result.data.perPatientTime[0].per_patient_time; //perPatientTime convert to Minute

              var a = doctorPatientTime.split(':'); // split it at the colons

              var minutes = +a[0] * 60 + +a[1]; // convert to minute
              //parse In

              var startTime = parseIn(doctorStartTime);
              var endTime = parseIn(doctorEndTime); //call to getTimeIntervals function

              intervals = getTimeIntervals(startTime, endTime, minutes); //if intervals array length is grater then 0 then process

              if (intervals.length > 0) {
                $('.available-slot-heading').css('display', 'block');
                $('.color-information').css('display', 'block');
                var index;
                var timeStlots = '';

                for (index = 0; index < intervals.length; ++index) {
                  var data = [{
                    'index': index,
                    'timeSlot': intervals[index]
                  }];
                  var timeSlot = prepareTemplateRender('#appointmentSlotTemplate', data);
                  timeStlots += timeSlot;
                }

                $('.available-slot').append(timeStlots);
              } // display Day Name and time


              if (result.data.scheduleDay[0].available_from != '00:00:00' && result.data.scheduleDay[0].available_to != '00:00:00' && doctorStartTime != doctorEndTime) {
                $('.doctor-schedule').css('display', 'block');
                $('.color-information').css('display', 'block');
                $('.day-name').html(result.data.scheduleDay[0].available_on);
                $('.schedule-time').html('[' + result.data.scheduleDay[0].available_from + ' - ' + result.data.scheduleDay[0].available_to + ']');
              } else {
                $('.doctor-schedule').css('display', 'none');
                $('.color-information').css('display', 'none');
                $('.error-message').css('display', 'block');
                $('.error-message').html('Doctor Schedule not available this date.');
              }
            } else {
              $('.doctor-schedule').css('display', 'none');
              $('.color-information').css('display', 'none');
              $('.error-message').css('display', 'block');
              $('.error-message').html('Doctor Schedule not available this date.');
            }
          }
        }
      }
    });

    if (isCreate || isEdit) {
      var getCreateTimeSlot = function getCreateTimeSlot() {
        if (isCreate) {
          var data = {
            editSelectedDate: selectedDate,
            doctor_id: doctorId
          };
        } else {
          var data = {
            editSelectedDate: selectedDate,
            editId: appointmentEditId,
            doctor_id: doctorId
          };
        }

        $.ajax({
          url: getBookingSlot,
          type: 'GET',
          data: data,
          success: function success(result) {
            alreadyCreateTimeSlot = result.data.bookingSlotArr;

            if (result.data.hasOwnProperty('onlyTime')) {
              if (result.data.bookingSlotArr.length > 0) {
                editTimeSlot = result.data.onlyTime.toString();
                $.each(result.data.bookingSlotArr, function (index, value) {
                  $.each(intervals, function (i, v) {
                    if (value == v) {
                      $('.time-interval').each(function () {
                        if ($(this).data('id') == i) {
                          if ($(this).html() != editTimeSlot) {
                            $(this).parent().css({
                              'background-color': '#ffa721',
                              'border': '1px solid #ffa721',
                              'color': '#ffffff'
                            });
                            $(this).parent().addClass('booked');
                            $(this).parent().children().prop('disabled', true);
                          }
                        }
                      });
                    }
                  });
                });
              }

              $('.time-interval').each(function () {
                if ($(this).html() == editTimeSlot && result.data.bookingSlotArr.length > 0) {
                  $(this).parent().addClass('time-slot-book');
                  $(this).parent().removeClass('booked');
                  $(this).parent().children().prop('disabled', false);
                  $(this).click();
                }
              });
            } else if (alreadyCreateTimeSlot.length > 0) {
              $.each(alreadyCreateTimeSlot, function (index, value) {
                $.each(intervals, function (i, v) {
                  if (value == v) {
                    $('.time-interval').each(function () {
                      if ($(this).data('id') == i) {
                        $(this).parent().addClass('time-slot-book');
                        $('.time-slot-book').css({
                          'background-color': '#ffa721',
                          'border': '1px solid #ffa721',
                          'color': '#ffffff'
                        });
                        $(this).parent().addClass('booked');
                        $(this).parent().children().prop('disabled', true);
                      }
                    });
                  }
                });
              });
            }
          }
        });
      };

      var delayCall = 200;
      setTimeout(getCreateTimeSlot, delayCall);
    }
  }); // if edit record then trigger change

  var editTimeSlot;

  if (isEdit) {
    $('#doctorId').trigger('change', function (event) {
      doctorId = $(this).val();
    });
    $('#opdDate').trigger('dp.change', function () {
      var selected = new Date($(this).val());
    });
  } //parseIn date_time


  window.parseIn = function (date_time) {
    var d = new Date();
    d.setHours(date_time.substring(11, 13));
    d.setMinutes(date_time.substring(14, 16));
    return d;
  }; //make time slot list


  window.getTimeIntervals = function (time1, time2, duration) {
    var arr = [];

    while (time1 < time2) {
      arr.push(time1.toTimeString().substring(0, 5));
      time1.setMinutes(time1.getMinutes() + duration);
    }

    return arr;
  }; //slot click change color


  var selectedTime;
  $(document).on('click', '.time-interval', function (event) {
    var appointmentId = $(event.currentTarget).data('id');

    if ($(this).data('id') == appointmentId) {
      if ($(this).parent().hasClass('booked')) {
        $('.time-slot-book').css('background-color', '#ffa0a0');
      }
    }

    selectedTime = $(this).text();
    $('.time-slot').removeClass('time-slot-book');
    $(this).parent().addClass('time-slot-book');
  }); //create appointment

  $('#appointmentForm').on('submit', function (event) {
    if (selectedTime == null || selectedTime == '') {
      $('#validationErrorsBox').show().html('Please select appointment time slot');
      return false;
    }

    event.preventDefault();
    screenLock();
    var formData = $(this).serialize() + '&time=' + selectedTime;
    $.ajax({
      url: appointmentSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = appointmentIndexPage;
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
        screenUnLock();
      }
    });
  });
  var editTimeSlot;
  $(document).on('click', '.time-interval', function () {
    editTimeSlot = $(this).text();
  }); //Edit appointment

  $('#editAppointmentForm').on('submit', function (event) {
    event.preventDefault();
    screenLock();
    var formData = $(this).serialize() + '&time=' + editTimeSlot;
    $.ajax({
      url: appointmentSaveUrl,
      type: 'POST',
      dataType: 'json',
      data: formData,
      success: function success(result) {
        displaySuccessMessage(result.message);
        window.location.href = appointmentIndexPage;
      },
      error: function error(result) {
        printErrorMessage('#validationErrorsBox', result);
        screenUnLock();
      }
    });
  });
});

/***/ }),

/***/ 9:
/*!***************************************************************!*\
  !*** multi ./resources/assets/js/appointments/create-edit.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/appointments/create-edit.js */"./resources/assets/js/appointments/create-edit.js");


/***/ })

/******/ });