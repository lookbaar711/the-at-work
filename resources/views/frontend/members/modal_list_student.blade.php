<!-- modal list student -->
<div class="modal fade bd-example-modal-lg" id="modal_student" role="dialog"  >
     <div class="modal-dialog modal-lg" style="max-width: 900px">
         <!-- Modal content-->
         <div class="modal-content" >
             <div class="modal-header">
                 <h5 class="modal-title">@lang('frontend/members/title.student_list')</h5>
             </div>

             <div class="modal-body" style="overflow-x: auto;">
                 <table class="table table-striped" border="0" >
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>@lang('frontend/members/title.student_course_register_date')</th>
                             <th>@lang('frontend/members/title.student_fullname')</th>
                             <th>@lang('frontend/members/title.student_email')</th>
                             <th>@lang('frontend/members/title.student_mobile_no')</th>
                         </tr>
                     </thead>
                     <tbody id="student">

                     </tbody>
                 </table>
             </div>

             <div class="modal-footer">
                <div class="col-md-12" style="text-align: center;">
                    <button type="button" class="btn btn-success" data-dismiss="modal">@lang('frontend/members/title.close_button')</button>
                </div>
             </div>
         </div>
     </div>
 </div>
