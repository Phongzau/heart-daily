<section class="section">
    <div class="section-header">
        <h1>Coupons</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Coupon</h4>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="storeCoupon">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" wire:model="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Code</label>
                                <input type="text" wire:model="code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="text" wire:model="quantity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Max Use Per Person</label>
                                <input type="text" wire:model="max_use" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Start Date</label>
                                        <input type="date" wire:model="start_date" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">End Date</label>
                                        <input type="date" wire:model="end_date" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputState">Discount Type</label>
                                        <select id="inputState" wire:model="discount_type" class="form-control">
                                            <option value="" hidden>Select</option>
                                            <option value="percent">Percentage (%)</option>
                                            <option value="amount">Amount (đ)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Discount Value <code id="discount-label">(?)</code></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="discount-unit">?</div>
                                            </div>
                                            <input disabled id="discount_value" type="number" wire:model="discount"
                                                class="form-control currency">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Minium order value <code>(đ)</code></label>
                                <input type="number" value="0" id="min_order_value" wire:model="min_order_value"
                                    class="form-control">
                            </div>

                            <div class="form-group mt-2">
                                <label for="inputState">Publish</label> <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="customRadioInline"
                                        wire:model="is_publish" checked value="1" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="customRadioInline"
                                        wire:model="is_publish" value="0" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputState">Status</label>
                                <select id="inputState" wire:model="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
