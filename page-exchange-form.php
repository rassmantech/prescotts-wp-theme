<?php /* Template Name: Exchange Form */ ?>
<?php get_header('exchange'); ?>
<main>
    <div class="content">
        <div class="no-builder">
            <div class="container">
                <div class="twelve columns">
                    <?php if (is_user_logged_in()): ?>
                    <div class="row">
                        <h1>Exchange Parts Return Form</h1>
                    </div>
                    <div class="row">
                        <div class="exchange-form">
                            <form id="exchange-form" action="exchange-pdf-creator" method="post" target="_blank" onsubmit="prescotts.exchangeFormListener()">
                                <section class="cf">
                                    <div class="full">
                                        <h2>Order Information:</h2>
                                    </div>
                                    <div class="quarter">
                                        <input required type="text" name="businessWorks" placeholder="Business Works S/O#" maxlength="50"/>
                                    </div>
                                    <div class="quarter">
                                        <input required type="text" name="customerAccount" placeholder="Customer Account#" maxlength="50"/>
                                    </div>
                                    <div class="quarter">
                                        <div class="select-wrap">
                                            <select required type="text" name="partType" placeholder="Part Type">
                                                <option value="">- Select Part -</option>
                                                <option value="INV">Inventory Part</option>
                                                <option value="BIL">Billable Part</option>
                                                <option value="WAR">Warranty Part</option>
                                                <option value="SCP">Service Contract Part</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="full">
                                        <input required type="text" name="facilityName" placeholder="Facility Name" maxlength="50"/>
                                    </div>
                                    <div class="full">
                                        <input required type="text" name="mailingAddress" placeholder="Mailing Address" maxlength="140"/>
                                    </div>
                                    <div class="quarter">
                                        <input required type="text" name="mailingCity" placeholder="City" maxlength="50"/>
                                    </div>
                                    <div class="quarter">
                                        <div class="select-wrap">
                                            <select required name="mailingState">
                                                <option value="">- Select State -</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District Of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="quarter">
                                        <input required type="text" name="mailingZip" placeholder="Zip" maxlength="12"/>
                                    </div>
                                    <div class="full">
                                        <h3>Biomed Contact:</h3>
                                    </div>
                                    <div class="full">
                                        <input required type="text" name="biomedName" placeholder="Biomed Name" maxlength="50"/>
                                    </div>
                                    <div class="half">
                                        <input required type="tel" name="biomedPhone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="Biomed Phone"  maxlength='12'/>
                                    </div>
                                    <div class="half">
                                        <input required type="email" name="biomedEmail" placeholder="Biomed Email" maxlength="50" />
                                    </div>
                                    <div class="full">
                                        <h3>Prescott's Contact:</h3>
                                    </div>
                                    <div class="quarter">
                                        <input type="text" name="repName" placeholder="Prescott's Rep" maxlength="50"/>
                                    </div>
                                    <div class="quarter">
                                        <input type="text" name="repEmail" placeholder="Rep Email" maxlength="50"/>
                                    </div>
                                    <div class="quarter">
                                        <div class="select-wrap">
                                            <select required name="repRegion" placeholder="Region">
                                                <option value="">- Select Region -</option>
                                                <option value="west">West</option>
                                                <option value="midwest">Midwest</option>
                                                <option value="south">South</option>
                                                <option value="northeast">Northeast</option>
                                                <option value="southeast">Southeast</option>
												<option value="uk">UK</option>
                                            </select>
                                        </div>
                                    </div>
                                </section>
                                <section class="cf">
                                    <div class="full">
                                        <h2>Parts Information:</h2>
                                    </div>
                                    <div class="full">
                                        <table class="exchange-table" id="parts" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <thead>
                                                <th>Quantity</th>
                                                <th>Part#</th>
                                                <th>Description</th>
                                                <th class="hidden">&nbsp;</th>
                                            </thead>
                                            <tbody>
                                                <tr data-part="1">
                                                    <td class="qty">
                                                        <input required type="number" name="partQty1" id="partQty" value="1" />
                                                    </td>
                                                    <td class="number">
                                                        <input required type="text" name="partNumber1" id="partNumber" placeholder="Part#" />
                                                    </td>
                                                    <td class="description">
                                                        <input required type="text" name="partDescription1" id="partDescription" placeholder="Description" />
                                                    </td>
                                                    <td class="actions">
                                                        <a href="javascript:void(0);" class="add"></a>
                                                        <a href="javascript:void(0);" class="remove"></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                                <section class="cf">
                                    <div class="full">
                                        <input type="submit" name="submit" value="Submit"/>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="exchange-login">
                        <div class="row">
                            <h1>Log In</h1>
                        </div>
                        <div class="row">
                            <h3>You must be logged in to access the Return/Exchange system.</h3>
                            <?php
                                $loginargs = array(
                                    'echo'           => true,
                                    'redirect'       => site_url($_SERVER['REQUEST_URI']),
                                    'remember'       => true,
                                    'form_id'        => 'exchange-login',
                                );
                                wp_login_form($loginargs);
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer('exchange'); ?>
