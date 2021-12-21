<script>
import { Inertia } from '@inertiajs/inertia';
import { page } from "@inertiajs/inertia-svelte";

  $: ({ app } = $page.props);

  let acceptTradeTerms = () => {
    BlockToast.fire({
      text: 'Please wait...'
    })

    Inertia.put(route('frontdeskusers.terms.accept'));
  }
</script>

<style>
  .main-heading{
    display: block;
    font-size: 2em;
    font-weight: bold;
    color:black;
    margin-bottom: 1.15em;
    text-align: center;
  }
</style>

<main
    style="background-color: #222533; padding: 20px; font-size: 14px; line-height: 1.43; font-family: 'Helvetica Neue', 'Segoe UI', Helvetica, Arial, sans-serif;">
    <div
        style="max-width: 900px; margin: 0px auto; background-color: #f9f9f9; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
        <table style="width: 100%;">
            <tr>
                <td style="background-color: #fff;">
                    <img alt="" src="img/logo-color.png" style="width: 70px; padding: 20px">
                </td>
            </tr>
        </table>
        <div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
            <h1 style="margin-top: 0px; text-aligg: center;" class="main-heading">INVESTMENT TERMS AND CONDITION</h1>
            <div style="color: #636363; font-size: 14px;">
                <p>This <strong>INVESTMENT</strong> Terms and Condition is between <strong>{app.name} TRADING COMPANY</strong> of {app.address}. Investor you
                    should read the agreement carefully, understand and agree with the terms and conditions before you enter into a contractual relationship with us.
                </p>
                <p>
                    The Company is incorporated in London United Kingdom, having its Registered 103 Seven Sisters,
                    London, United Kingdom, N7 7QP with license registration number 12414789
                </p>
                <p>
                    <strong>{app.name}</strong> is a pioneer online trading group that was founded in 2007, and
                    has revolutionized currency, commodities, indices and options trading in over 160 countries
                    ever since. We are pioneers in developing online trading as a consumer product, and
                    one of the leaders in the market with customized technology and personal service
                    tailored to all levels of knowledge and experience traders ("you"), accessible from any
                    location. We develop easy and user friendly online trading platforms for execution-only
                    transactions in the over-the-counter spot foreign exchange, forward foreign exchange,
                    CFD commodities and CFD Index markets ("Financial Products") and options trading.
                </p>
                <p>
                    We further provide you with real time tradable BID-ASK tradable prices by collecting
                    and aggregating information sourced through, independent price providers, relevant
                    exchanges and interbank participants who normally supply liquidity and information to
                    the global FX and Futures market and distributes the real time BID-ASK tradable prices
                    to you via our proprietary and 3rd party trading platforms.
                </p>
                <div>
                    <h2>1. APPOINTMENT & ACCESS</h2>
                    <p>
                        The investor hereby appoints the investment account manager, as his Forex Trader and shall grant
                        the investment account manager access to the Forex Trading Account(s) for trading purpose only
                        It's very important to understand that the Forex account management agreement never allows
                        the account managers to fund or withdraw funds from the investor account.
                        The international anti money laundering laws only allow the investor to make any
                        funding and withdrawal to their brokerâ€™s account and it can be only accepted if
                        the holder of the brokerâ€™s account and the holder of the bank account is exactly the same.
                        only the client have access to withdraw and add funds in the account
                    </p>
                </div>
                <div>
                    <h2>2. PROFIT SHARE</h2>
                    <p>
                        Profit is shared every week with the investor taking 60% and the account manager takes 25%.
                        the remaining 15% is for withdrawal fee consisting of all trading expense
                        If the market makes less than or equals to 10% profit, the account manager will not partake in
                        the profit share.
                    </p>
                </div>
                <div>
                    <h2>3. NON-REFUNDABLE FEES</h2>
                    <p>
                        Initial investment is non fundable if the profit generated is more or equal to 10%
                        (ie the initial investment is only refundable when no profit is generated) </p>
                    <p><strong>INVESTMENT AMOUNT: </strong>
                        The capital investment amount is the amount deposited by the investor into his/her forex trading
                        account
                        to be invested and managed by the account manager. The invested amount shall be a minimum of
                        $500
                    </p>
                </div>
                <div>
                    <h2>4. TRADING ID</h2>
                    <p>
                        A trading account identity number will be granted to the investor upon investing he/she shall
                        only share the this
                        id with his/her account manager only.</p>
                </div>
                <div>
                    <h2>5. DEPOSIT AND WITHDRAWAL</h2>
                    <p>Deposit shall only be made via <strong>BITCOIN PAYMENT, ACCOUNT DEPOSIT AND PAYPAL</strong></p>
                    <p>
                        <strong>Documentation: </strong> So as to proceed with the execution of a withdrawal order, you
                        need to provide us with documentation verifying your identity so that we can
                        authenticate your identity, as required by law, credit card companies' regulations and
                        our internal policies
                    </p>
                    <p>
                        <strong>Withdrawals:</strong> Withdrawals to bank accounts may take a longer time period to be
                        credited to your account. When choosing an account base currency, other than the
                        currency used in your debit or credit card, you may incur fees which are due to
                        currency conversion or other charges; therefore your refunded amount may vary
                        slightly from the sum that you initially deposited in your account base currency. Please
                        read the terms and conditions of the bank that you hold an account with regarding their
                        charge policies in currency conversion.
                    </p>
                    <p>
                        <strong>THIRD PARTY FEES: </strong> All withdrawal attracts third party fees like taxs, signals,
                        c.o.t(cost of transfer) etc
                        depending on your country. All third party fees must be paid before withdrawal can be processed.
                    </p>
                </div>
                <div>
                    <h2>6. Taxation</h2>
                    <p>
                        You may be liable to pay taxes arising out of your trading transaction, usually related
                        to the profits you made, depending on the local jurisdictions in which you are a tax
                        resident in.
                    </p>
                </div>
                <div>
                    <h2>7. DATA PROCESSING - PRIVACY POLICY - COOKIES</h2>
                    <p>
                        You may rest assured that we take all measures to ensure that the information
                        you entrust us with will be treated as confidential. Your personal data that we require
                        throughout our cooperation, is safely stored in our electronic systems, it is treated as
                        CONFIDENTIAL and it is protected by Data Protection laws. It is our policy not to
                        disclose client information to non-affiliated third parties except with your consent or
                        where required for legal or regulatory purposes.
                        Notwithstanding the above, there are certain cases where information cannot be
                        considered confidential. This occurs where it can be proved that such information is</p>
                    <ul>
                        <li>Already available to the public, through no act or omission of the recipient or of any
                            other third party owing an obligation of confidence to the receiver;
                        </li>
                        <li>Rightfully received
                            from a third party without any restrictions as to its use or disclosure; </li>
                        <li>Required to be
                            disclosed pursuant to legal or regulatory requirement.
                        </li>
                    </ul>
                    <p>
                        <strong>Cookies</strong> - Cookies are small text files that are sent to and stored on your
                        device,
                        such as desktop and laptop, smartphone, tablet/phablet, for accessing the Internet,
                        when you visit a website or a webpage. Cookies allow a website to recognise a user's
                        device. The objective of cookies use is to improve and make the user's experience

                    </p>
                </div>
                <div>
                    <h2>8. INTELLECTUAL PROPERTY</h2>
                    <p>
                        All intellectual property of our proprietary platforms, products and services belongs
                        to the Company. We allow you only the access and the use of the platforms for the
                        performance of the trade transactions. Intellectual Property includes but it is not limited
                        to any copyright on materials, the platforms, software, processes, source code,
                        websites, patents, designs, databases, patents, trademarks, methodology, know how,
                        trade secrets, business plans, promotional and marketing material, in any sort of form.
                        We retain all rights, title and interest in all our Intellectual Property rights, arising out of
                        this Agreement.
                    </p>
                </div>
                <div>
                    <h2>9. TERMINATION</h2>
                    <p>
                        If you wish to close your account, you must notify us in writing. If we wish to close
                        your account, we will also notify you in writing by giving reasonable notice, unless there
                        are grounds where we need to terminate our contractual relationship with you earlier or
                        even immediately without notice.

                    </p>
                </div>
            </div>
            <div style="margin: 40px 0px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center; padding-left: 20px;">
                            <form on:submit|preventDefault|stopPropagation="{acceptTradeTerms}">
                              <button type="submit" style="cursor: pointer; padding: 8px 20px; background-color: #0c0c0e; color: #fff; font-weight: bolder; font-size: 16px; display: inline-block; margin: 10px 0px; text-decoration: none;">
                                Accept Terms & Conditions
                              </button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="background-color: #F5F5F5; padding: 40px; text-align: center;">
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
                <div style="color: #A5A5A5; font-size: 10px; margin-bottom: 5px;">{app.address}</div>
                <div style="color: #A5A5A5; font-size: 10px;">Copyright {new Date().getFullYear() } {app.name}. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</main>
