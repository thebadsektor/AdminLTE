  //DOM elements
  const DOMstrings = {
      stepsBtnClass: 'multisteps-form__progress-btn',
      stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
      stepsBar: document.querySelector('.multisteps-form__progress'),
      stepsForm: document.querySelector('.multisteps-form__form'),
      stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
      stepFormPanelClass: 'multisteps-form__panel',
      stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
      stepPrevBtnClass: 'js-btn-prev',
      stepNextBtnClass: 'js-btn-next'
  };


  //remove class from a set of items
  const removeClasses = (elemSet, className) => {

      elemSet.forEach(elem => {

          elem.classList.remove(className);

      });

  };

  //return exect parent node of the element
  const findParent = (elem, parentClass) => {

      let currentNode = elem;

      while (!currentNode.classList.contains(parentClass)) {
          currentNode = currentNode.parentNode;
      }

      return currentNode;

  };

  //get active button step number
  const getActiveStep = elem => {
      return Array.from(DOMstrings.stepsBtns).indexOf(elem);
  };

  //set all steps before clicked (and clicked too) to active
  const setActiveStep = activeStepNum => {

      //remove active state from all the state
      removeClasses(DOMstrings.stepsBtns, 'js-active');

      //set picked items to active
      DOMstrings.stepsBtns.forEach((elem, index) => {

          if (index <= activeStepNum) {
              elem.classList.add('js-active');
          }

      });
  };

  //get active panel
  const getActivePanel = () => {

      let activePanel;

      DOMstrings.stepFormPanels.forEach(elem => {

          if (elem.classList.contains('js-active')) {

              activePanel = elem;

          }

      });

      return activePanel;

  };

  //open active panel (and close unactive panels)
  const setActivePanel = activePanelNum => {

      //remove active class from all the panels
      removeClasses(DOMstrings.stepFormPanels, 'js-active');

      //show active panel
      DOMstrings.stepFormPanels.forEach((elem, index) => {
          if (index === activePanelNum) {

              elem.classList.add('js-active');

              setFormHeight(elem);

          }
      });

  };

  //set form height equal to current panel height
  const formHeight = activePanel => {

      const activePanelHeight = activePanel.offsetHeight;

      DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

  };

  const setFormHeight = () => {
      const activePanel = getActivePanel();

      formHeight(activePanel);
  };

  //STEPS BAR CLICK FUNCTION
  DOMstrings.stepsBar.addEventListener('click', e => {

      //check if click target is a step button
      const eventTarget = e.target;

      if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
          return;
      }
      //get active button step number
      const activeStep = getActiveStep(eventTarget);
      $(function() {
          if ($(".step_btn" + activeStep).attr("step_status") == "lock_btn") {
              myalert_warning_af("Follow step by step process!!","nothing");
          } else {
              //set all steps before clicked (and clicked too) to active
              setActiveStep(activeStep);

              //open active panel
              setActivePanel(activeStep);
          }
      });

  });

  //PREV/NEXT BTNS CLICK
  DOMstrings.stepsForm.addEventListener('click', e => {

      const eventTarget = e.target;

      //check if we clicked on `PREV` or NEXT` buttons

      if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`))) {
          return;
      } else {
          //find active panel
          const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

          let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);
          // check if triger prev
          if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
              //set active step and active panel onclick
              //bact to last step function 

              //   trigger if back to 1st step
              if (activePanelNum == 1) {
                  //   ajax check if business is save
                  $(function() {
                      var business_id = $("#business_id").val();
                      $.ajax({
                          type: "POST",
                          url: "bpls/ajax_multistep_previous_trigger.php",
                          data: { business_id: business_id },
                          success: function(result) {
                              if (result == "ok") {
                                  $(".step0_next_btn").html("Update");
                                  $(".step0_next_btn").attr("btn_name", "update");
                              }
                          }
                      });
                  });

              }


              if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                  activePanelNum--;
              } else {
                  activePanelNum++;
              }
              setActiveStep(activePanelNum);
              setActivePanel(activePanelNum);
          } else {

              // triger action for first page only
              if (activePanelNum == 0) {

                  // trigger  next process
                  $(function() {
                      // modal validation

                      var error_count = 0;
                      $(".i_step" + activePanelNum).each(function() {

                          // check if select or input
                          if ($(this).is("select")) {
                              if ($(this).val() == "") {
                                  //   alert($(this).prop("name"))
                                  // add color in closet span
                                  $(this).closest("div").find("label").css({ "color": "#c43831" });
                                  //   set css this input
                                  $(this).addClass("border_red");
                                  error_count++;
                              } else {
                                  $(this).closest("div").find("label").css({ "color": "#333" })
                                  $(this).removeClass("border_red");

                              }
                          } else {
                              if ($(this).val() == "") {
                                  //   alert($(this).prop("name"))
                                  //   alert($(this).prop("class"))
                                  // add color in closet span
                                  $(this).closest("div").find("label").css({ "color": "#c43831" });
                                  //   set css this input
                                  $(this).addClass("border_red");
                                  error_count++;
                              } else {

                                  $(this).closest("div").find("label").css({ "color": "#333" });
                                  $(this).removeClass("border_red");
                              }
                          }

                      });

                      var modal_error_count = 0;
                      $(".in_modal0").each(function() {
                          if ($(this).val() == "") {
                              modal_error_count++;
                          }
                      });
                      if (modal_error_count > 0) {
                          $(".modal_class").addClass("border_red");
                      } else {
                          $(".modal_class").removeClass("border_red");
                      }


                      //   radio checking 
                      //   if step is 0 or first
                    //   if ($('input[name="tax_incentive_status"]:checked').length == 0) {
                    //       $(".r1_step0").css({ "border": "2px solid #c43831" });
                    //       error_count++;
                    //   } else {
                    //       $(".r1_step0").css({ "border": "none" });
                    //   }

                      //   same address in modal busienss and owners
                      //   if step is 0 or first
                      if ($('input[name="same_address"]:checked').length == 0) {
                          $(".r2_step0").css({ "border": "2px solid #c43831" });
                          error_count++;
                      } else {
                          $(".r2_step0").css({ "border": "none" });
                      }

                      //   same address in modal busienss and owners
                      //   if step is 0 or first
                      if ($('input[name="rented_status"]:checked').length == 0) {
                          $(".r3_step0").css({ "border": "2px solid #c43831" });
                          error_count++;
                      } else {
                          $(".r3_step0").css({ "border": "none" });
                      }



                      //checking for error
                      if (error_count > 0) {
                          myalert_warning_af("Please Check your inputs","nothing");

                      } else {

                          // Save Info

                          $(document).ready(function() {
                              var btn_name = $("#btn_step_1").attr("btn_name");

                              myalert_warning("Are you sure you want to " + btn_name + " this application? ");
                              $(".w35343_btn").click(function() {
                                  // ---------
                                  var serialize = $("#m_form").serialize();
                                  $.ajax({
                                      type: "POST",
                                      url: "bpls/ajax_application_save.php",
                                      data: { serialize: serialize },
                                      success: function(result) {
                                          if (btn_name == "save") {
                                              myalert_success_af("Application form submited!","nothing");
                                          } else {
                                              myalert_success_af("Application form updated!","nothing");
                                          }
                                          $(".assessment_body").html(result);

                                          window.scrollTo(0, 0);
                                      }

                                  });

                                  // no error traces
                                  //set active step and active panel onclick
                                  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                                      activePanelNum--;
                                  } else {
                                      activePanelNum++;
                                  }

                                  setActiveStep(activePanelNum);
                                  setActivePanel(activePanelNum);
                                  //   unlock top clickable badge
                                  $(".step_btn" + activePanelNum).attr("step_status", "unlock_btn");

                              });
                              $(".w64534_btn").click(function() {
                                  setTimeout(function() {
                                      $('#myModal_alert_w').remove();
                                      $('.modal-backdrop').remove();
                                  }, 0);
                              });


                          });


                      }
                  });
                  //   trigger next/ in second page only
              } else if (activePanelNum == 1) {
                  var a = 0;
                //   check  assess  using btn existence
                  $(".assess_btn").each(function () {
                      a++;
                  });
                  if (a == 1) {
                      myalert_danger_af("Please finish your assessment!","nothing");
                  } else {
                      // no error traces
                    //set active step and active panel onclick
                  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                      activePanelNum--;
                  } else {
                       activePanelNum++;
                  }

                  setActiveStep(activePanelNum);
                   setActivePanel(activePanelNum);
                    //   unlock top clickable badge
                   $(".step_btn" + activePanelNum).attr("step_status", "unlock_btn");
                  }
              }else if (activePanelNum == 2) {
                  error_counter_r = 0;
                  //   radio checking 
                      //   if step is 0 or first
                      if ($('input[name="approval_dec"]:checked').val() == 1) {
                          error_counter_r++;
                      } 
                  if (error_counter_r == 1) {
                    //   $(".step_btn3").attr("step_status", "unlock_btn");
                         // no error traces
                    //set active step and active panel onclick
                  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                      activePanelNum--;
                  } else {
                       activePanelNum++;
                  }

                  setActiveStep(activePanelNum);
                   setActivePanel(activePanelNum);
                    //   unlock top clickable badge
                   $(".step_btn" + activePanelNum).attr("step_status", "unlock_btn");
                  } else {
                    //   error message
                      myalert_warning_af("Only approved application can proceed to payment","nothing");
                  }
              }else if (activePanelNum == 3) {
                   //set active step and active panel onclick
                  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                      activePanelNum--;
                  } else {
                       activePanelNum++;
                  }

                  setActiveStep(activePanelNum);
                   setActivePanel(activePanelNum);
                    //   unlock top clickable badge
                   $(".step_btn" + activePanelNum).attr("step_status", "unlock_btn");
              }else if (activePanelNum == 4) {
                    //set active step and active panel onclick
                  if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                      activePanelNum--;
                  } else {
                       activePanelNum++;
                  }

                  setActiveStep(activePanelNum);
                   setActivePanel(activePanelNum);
                    //   unlock top clickable badge
                   $(".step_btn" + activePanelNum).attr("step_status", "unlock_btn");
              }


          }





      }
  });

  //SETTING PROPER FORM HEIGHT ONLOAD
  window.addEventListener('load', setFormHeight, false);

  //SETTING PROPER FORM HEIGHT ONRESIZE
  window.addEventListener('resize', setFormHeight, false);

  //changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

  const setAnimationType = newType => {
      DOMstrings.stepFormPanels.forEach(elem => {
          elem.dataset.animation = newType;
      });
  };

  //selector onchange - changing animation
  //   const animationSelect = document.querySelector('.pick-animation__select');

  //   animationSelect.addEventListener('change', () => {
  //       const newAnimationType = animationSelect.value;

  //       setAnimationType(newAnimationType);
  //   });