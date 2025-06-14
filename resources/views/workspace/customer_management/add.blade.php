<div class="offcanvas offcanvas-end" id="add-new-record">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title">Add Member</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form id="form-add-new-record" enctype="multipart/form-data" onsubmit="return false">
      <!-- Full Name -->
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" required>
      </div>

      <!-- Gender -->
      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select class="form-control" id="gender" name="gender" required>
          <option value="">-- Select Gender --</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>

      <!-- Phone Number -->
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>

      <!-- Nationality -->
      <div class="mb-3">
        <label class="form-label">Nationality</label>
        <select name="nationality"  class="form-control" id="nationality" >
          <option value="Tanzania">Tanzania</option>
          <option value="Kenya">Kenya</option>
          <option value="Uganda">Uganda</option>
        </select>
       <!-- <input type="text" class="form-control" id="nationality" name="nationality">-->
      </div>


      <!-- Address -->
      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address">
      </div>

   

      <!-- Payment Plan -->
      <div class="mb-3">
        <label class="form-label">Payment Plan</label>
        <select  class="form-control" id="payment_plan" name="payment_plan">
          <option >-- Select Payment Plan --</option>
          <option value="Daily">Daily</option>
          <option value="Weekly">Weekly</option>
          <option value="Two Weeks">Two Weeks</option>
          <option value="Monthly">Monthly</option>
          <option value="Three Monthly">Three Monthly</option>
          <option value="Six Monthly">Six Monthly</option>
          <option value="Annual">Annual</option>
        </select>
      </div>
      <!-- Start Date -->
      <div class="mb-3">
        <label class="form-label">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
      </div>

      <div class="mb-3" id="expiry_date_group">
        <label class="form-label">Expiry Date</label>
        <input type="date" class="form-control" id="expiry_date" name="expiry_date">
      </div>

      <!-- Next of Kin Name -->
      <div class="mb-3">
        <label class="form-label">Next of Kin Name</label>
        <input type="text" class="form-control" id="next_of_kin_name" name="next_of_kin_name">
      </div>

      <!-- Next of Kin Relation -->
      <div class="mb-3">
        <label class="form-label">Next of Kin Relation</label>
        <input type="text" class="form-control" id="next_of_kin_relation" name="next_of_kin_relation">
      </div>

      <!-- Next of Kin Phone -->
      <div class="mb-3">
        <label class="form-label">Next of Kin Phone</label>
        <input type="text" class="form-control" id="next_of_kin_phone" name="next_of_kin_phone">
      </div>
{{--
         <!-- card_number-->
      <div class="mb-3">
        <label class="form-label">Card Number</label>
        <input type="text" class="form-control" id="card_number" name="card_number">
      </div>--}}

      <!-- body_weight -->
      <div class="mb-3">
        <label class="form-label">Body Weight</label>
        <input type="text" class="form-control" id="body_weight" name="body_weight">
      </div>

        <!-- body_weight -->
        <div class="mb-3">
        <label class="form-label">Body Height</label>
        <input type="text" class="form-control" id="body_height" name="body_height">
      </div>

         <!-- membership_category -->
         <div class="mb-3">
        <label class="form-label">Membership Category</label>
        <select name="membership_category" id="membership_category" class="form-control">
        <option >-- Select Membership Category --</option>
          <option value="Individual">Individual</option>
          <option value="Family">Family</option>
          <option value="Group">Group</option>
          <option value="Corporate">Corporate</option>
          <option value="Vip">Vip</option>
        </select>
        
      </div>

      <!-- programs -->
     <div class="mb-3">
        <label class="form-label">Programs</label>
        <select name="programs" id="programs" class="form-control">
        <option >-- Select Programs --</option>
          <option value="Cardio">Cardio</option>
          <option value="Aerobics">Aerobics</option>
          <option value="Kata Box">Kata Box</option>
          <option value="Surhet">Surhet</option>
          <option value="Zumba">Zumba</option>
          <option value="Tae Bo">Tae Bo</option>
          <option value="Weight Lifting">Weight Lifting</option>
        </select>
      </div>

         <!-- exercise_intentions -->
          <div class="mb-3">
              <label class="form-label">Exercise Intentions</label>
              <select name="exercise_intentions" id="exercise_intentions" class="form-control">
              <option >-- Select Exercise Intentions --</option>
                <option value="Lose Body Weight">Lose Body Weight</option>
                <option value="Maintain Weight">Maintain Weight</option>
                <option value="Body Building">Body Building</option>
              </select>
            </div>

  


   

              <div class="mb-3">
                <label class="form-label">Payment Status</label>
                <select  class="form-control" id="payment_status" name="payment_status">
                  <option>-- Select Payment Plan --</option>
                  <option value="Full Paid">Full Paid</option>
                  <option value="Partial">Partial Paid</option>
                  <option value="Not Paid">Not Paid</option>
                </select>
              </div>

      <!-- Health Notes -->
      <div class="mb-3">
        <label class="form-label">Health Notes</label>
        <textarea class="form-control" id="health_notes" name="health_notes"></textarea>
      </div>



      <!-- Assigned Trainer -->
      <div class="mb-3">
        <label class="form-label">Assigned Trainer</label>
        <select class="form-control" id="assigned_trainer_id" name="assigned_trainer_id">
          <option value="">-- Select Trainer --</option>
          <!-- Populate from DB if needed -->
        </select>
      </div>

 

      <!-- Preferred Workout Time -->
      <div class="mb-3">
        <label class="form-label">Preferred Workout Time</label>
        <select id="preferred_workout_time" name="preferred_workout_time" class="form-control" >
         <option >-- Select Preferred Workout Time --</option>
         <option value="Morning">Morning</option>
         <option value="Afternoon">Afternoon</option>
         <option value="Evening">Evening</option>
         <option value="Any Time">Any Time</option>
        </select>
      </div>
      <!-- Total Amount -->
      <div class="mb-3">
        <label class="form-label">Amount (Tsh)</label>
        <input type="number" class="form-control" id="calculated_amount" name="amount" >
      </div>

      <div class="mb-3" id="paid_amount_wrapper" style="display: none;">
        <label class="form-label">Paid Amount</label>
        <input type="number" class="form-control" id="paid_amount" name="paid_amount" min="0" step="any">
      </div>

      <div class="mb-3">
        <label class="form-label" id="payment_method_wrapper">Payment Method</label>
        <select id="payment_method" name="payment_method" class="form-control" >
         <option >-- Select Payment Method --</option>
         <option value="Cash">Cash</option>
         <option value="Mobile Money">Mobile Payment</option>
         <option value="Bank">Bank</option>
         <option value="Insurance">Insurance</option>
        </select>
      </div>

      <div class="mb-3" id="insurance_category_wrapper" style="display: none;">
  <label class="form-label">Insurance Category</label>
  <select name="insurance_category" id="insurance_category" class="form-control">
    <option>-- Select Insurance Category --</option>
    <option value="Jubilee">Jubilee</option>
    <option value="Strategies">Strategies</option>
    <option value="Assemble">Assemble</option>
    <option value="Other">Other</option>
  </select>
</div>



      <!-- Submit Buttons -->
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary" onclick="addCustomer()">Submit</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
    </form>
  </div>
</div>
