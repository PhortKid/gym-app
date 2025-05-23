# ✅ Income vs Expense Report - Task List

## 🔧 Users
- [x] Add User
- [x] Edit User
- [x] Delete User

## 🗃️ Member Plan
- [x] Add,edit,delete


## 📥 Controller Logic
- [x] Add `income_expense(Request $request)` method
- [x] Apply filters: daily / monthly / yearly
- [x] Get actual income totals grouped by category
- [x] Get actual expense totals grouped by category
- [x] Get expected income based on selected filter
- [x] Get projected expenses based on selected filter
- [x] Calculate actual totals (`$incomeTotal`, `$expenseTotal`)
- [x] Calculate expected totals (`$expectedRevenueTotal`, `$projectedExpenseTotal`)
- [x] Calculate differences and net profit

## 📊 Blade View
- [x] Create filter form (daily/monthly/yearly)
- [x] Display income table:
  - [x] Category name
  - [x] Actual amount
  - [x] Expected revenue
  - [x] Difference (actual - expected)
- [x] Display expense table:
  - [x] Category name
  - [x] Actual amount
  - [x] Projected expense
  - [x] Difference (actual - projected)
- [x] Summary section:
  - [x] Total Projected Revenue
  - [x] Total Projected Expenses
  - [x] Projected Profit
  - [x] Total Actual Revenue
  - [x] Total Actual Expenses
  - [x] Net Profit or Loss

## 🧪 Testing
- [ ] Confirm report accuracy for daily filter
- [ ] Confirm report accuracy for monthly filter
- [ ] Confirm report accuracy for yearly filter
- [ ] Test empty state when no data exists
- [ ] Test incorrect or missing filter inputs

## 🌟 Optional Features
- [ ] Add export to PDF or Excel
- [ ] Add chart view using Chart.js or similar
- [ ] Add authentication-based filtering (per user)
- [ ] Add date range custom filter

