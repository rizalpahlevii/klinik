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
/******/ 	return __webpack_require__(__webpack_require__.s = 135);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/dashboard/dashboard.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/dashboard/dashboard.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  'use strict';

  var timeRange = $('#time_range');
  var today = moment();
  var start = today.clone().startOf('week');
  var end = today.clone().endOf('week');
  var isPickerApply = false;
  $(window).on('load', function () {
    loadIncomeExpenseReport(start.format('YYYY-MM-D  H:mm:ss'), end.format('YYYY-MM-D  H:mm:ss'));
  });
  timeRange.on('apply.daterangepicker', function (ev, picker) {
    isPickerApply = true;
    start = picker.startDate.format('YYYY-MM-D  H:mm:ss');
    end = picker.endDate.format('YYYY-MM-D  H:mm:ss');
    loadIncomeExpenseReport(start, end);
  });

  window.cb = function (start, end) {
    timeRange.find('span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
  };

  cb(start, end);
  var lastMonth = moment().startOf('month').subtract(1, 'days');
  var thisMonthStart = moment().startOf('month');
  var thisMonthEnd = moment().endOf('month');
  timeRange.daterangepicker({
    startDate: start,
    endDate: end,
    opens: 'left',
    showDropdowns: true,
    autoUpdateInput: false,
    ranges: {
      'Today': [moment(), moment()],
      'This Week': [moment().startOf('week'), moment().endOf('week')],
      'Last Week': [moment().startOf('week').subtract(7, 'days'), moment().startOf('week').subtract(1, 'days')],
      'This Month': [thisMonthStart, thisMonthEnd],
      'Last Month': [lastMonth.clone().startOf('month'), lastMonth.clone().endOf('month')]
    }
  }, cb);

  window.loadIncomeExpenseReport = function (startDate, endDate) {
    $.ajax({
      type: 'GET',
      url: incomeExpenseReportUrl,
      dataType: 'json',
      data: {
        start_date: startDate,
        end_date: endDate
      },
      cache: false
    }).done(prepareReport);
  };

  window.prepareReport = function (result) {
    $('#daily-work-report').html('');
    var data = result.data;

    if (data.totalRecords === 0) {
      $('#income-expense-report-container').html('');
      $('#income-expense-report-container').append('<div align="center" class="no-record">No Records Found</div>');
      return true;
    } else {
      $('#income-expense-report-container').html('');
      $('#income-expense-report-container').append('<canvas id="daily-work-report"></canvas>');
    }

    var barChartData = {
      labels: data.date,
      datasets: [{
        label: 'Total Income',
        backgroundColor: 'rgba(0,255,0,0.6)',
        data: data.incomeTotal
      }, {
        label: 'Total Expense',
        backgroundColor: 'rgba(255,0,0,0.6)',
        data: data.expenseTotal
      }]
    };
    var ctx = document.getElementById('daily-work-report').getContext('2d');
    ctx.canvas.style.height = '400px';
    ctx.canvas.style.width = '100%';
    window.myBar = new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: true,
          text: 'Income and Expense Reports'
        },
        tooltips: {
          enabled: true,
          mode: 'single',
          callbacks: {
            label: function label(tooltipItem, data) {
              var label = data.datasets[tooltipItem.datasetIndex].label;
              var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              return label + ': ' + addCommas(datasetLabel);
            }
          }
        },
        elements: {
          rectangle: {
            borderWidth: 1,
            borderColor: 'rgb(0, 0, 0, 0.1)'
          }
        },
        responsive: false,
        scales: {
          xAxes: [{
            ticks: {
              autoSkip: false
            }
          }],
          yAxes: [{
            ticks: {
              callback: function callback(label) {
                return label / 1000 + 'k';
              }
            },
            scaleLabel: {
              display: true,
              labelString: 'Revenues (In ' + currentCurrencyName + ')'
            }
          }]
        }
      }
    });
  };
});

/***/ }),

/***/ 135:
/*!**********************************************************!*\
  !*** multi ./resources/assets/js/dashboard/dashboard.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/rizal-ganeshahusada/resources/assets/js/dashboard/dashboard.js */"./resources/assets/js/dashboard/dashboard.js");


/***/ })

/******/ });