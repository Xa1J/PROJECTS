import logging
from telegram import Update, InlineKeyboardButton, InlineKeyboardMarkup
from telegram.ext import Application, CommandHandler, CallbackQueryHandler, ContextTypes, ApplicationBuilder
import nest_asyncio
import asyncio

# Apply nest_asyncio to allow nested event loops
nest_asyncio.apply()

# Bot token from BotFather
BOT_TOKEN = '7187434159:AAHwpRaBoHMl8SFtKWda6gk0ryZXx6S43gE'

# Enable logging
logging.basicConfig(
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
    level=logging.INFO
)
logger = logging.getLogger(__name__)

# State definitions for conversation handler
LANGUAGE, COUNTRY, PAYMENT, PAYMENT_CONFIRMATION = range(4)

# Define the start command handler
async def start(update: Update, context: ContextTypes.DEFAULT_TYPE) -> int:
    keyboard = [
        [InlineKeyboardButton("English", callback_data='en')],
        [InlineKeyboardButton("Русский", callback_data='ru')]
    ]
    reply_markup = InlineKeyboardMarkup(keyboard)
    await update.message.reply_text('Please select a language:', reply_markup=reply_markup)
    return LANGUAGE

# Define the callback query handler
async def button(update: Update, context: ContextTypes.DEFAULT_TYPE) -> int:
    query = update.callback_query
    await query.answer()

    if query.data in ['en', 'ru']:
        context.user_data['language'] = query.data
        keyboard = [
            [InlineKeyboardButton("Zambia", callback_data='zambia')],
            [InlineKeyboardButton("Russia", callback_data='russia')]
        ]
        reply_markup = InlineKeyboardMarkup(keyboard)
        await query.edit_message_text(text="Please select your country:" if query.data == 'en' else "Пожалуйста, выберите вашу страну:", reply_markup=reply_markup)
        return COUNTRY

    elif query.data in ['zambia', 'russia']:
        context.user_data['country'] = query.data
        if query.data == 'zambia':
            keyboard = [
                [InlineKeyboardButton("Bank Card Payment", callback_data='bank_card')],
                [InlineKeyboardButton("Airtel Money", callback_data='airtel_money')],
                [InlineKeyboardButton("MTN Money", callback_data='mtn_money')],
                [InlineKeyboardButton("Zamtel Money", callback_data='zamtel_money')]
            ]
        else:
            keyboard = [
                [InlineKeyboardButton("Оплата банковской картой", callback_data='bank_card')],
                [InlineKeyboardButton("Мобильные деньги", callback_data='mobile_money')]
            ]
        reply_markup = InlineKeyboardMarkup(keyboard)
        await query.edit_message_text(text="Please select a payment method:" if context.user_data['language'] == 'en' else "Пожалуйста, выберите способ оплаты:", reply_markup=reply_markup)
        return PAYMENT

    elif query.data in ['bank_card', 'mobile_money', 'airtel_money', 'mtn_money', 'zamtel_money']:
        context.user_data['payment_method'] = query.data
        payment_details = "Payment method selected:\n" if context.user_data['language'] == 'en' else "Выбран способ оплаты:\n"
        if query.data == 'bank_card':
            payment_details += "Bank Card\nPlease use the following card number:\n\nCard Number: 2202 2011 9081 1865" if context.user_data['country'] == 'zambia' else "Банковская карта\nПожалуйста, используйте следующий номер карты:\n\nНомер карты: 1234 5678 9012 3456"
        elif query.data == 'mobile_money':
            payment_details += "Mobile Money\nPlease send the payment to the following mobile number:\n\nMobile Number: +79934184528" if context.user_data['country'] == 'zambia' else "Мобильные деньги\nПожалуйста, отправьте платеж на следующий мобильный номер:\n\nМобильный номер: +1234567890"
        elif query.data == 'airtel_money':
            payment_details += "Airtel Money\nPlease send the payment to the following mobile number:\n\nMobile Number: +260123456789" if context.user_data['language'] == 'en' else "Airtel Деньги\nПожалуйста, отправьте платеж на следующий мобильный номер:\n\nМобильный номер: +260123456789"
        elif query.data == 'mtn_money':
            payment_details += "MTN Money\nPlease send the payment to the following mobile number:\n\nMobile Number: +260987654321" if context.user_data['language'] == 'en' else "MTN Деньги\nПожалуйста, отправьте платеж на следующий мобильный номер:\n\nМобильный номер: +260987654321"
        elif query.data == 'zamtel_money':
            payment_details += "Zamtel Money\nPlease send the payment to the following mobile number:\n\nMobile Number: +260123123123" if context.user_data['language'] == 'en' else "Zamtel Деньги\nПожалуйста, отправьте платеж на следующий мобильный номер:\n\nМобильный номер: +260123123123"

        keyboard = [
            [InlineKeyboardButton("Confirm", callback_data='confirm')],
            [InlineKeyboardButton("Cancel", callback_data='cancel')]
        ]
        reply_markup = InlineKeyboardMarkup(keyboard)
        await query.edit_message_text(text=payment_details + "\n\nConfirm payment?" if context.user_data['language'] == 'en' else payment_details + "\n\nПодтвердить оплату?", reply_markup=reply_markup)
        return PAYMENT_CONFIRMATION

    elif query.data == 'confirm':
        keyboard = [
            [InlineKeyboardButton("Talk to Seller", url='https://t.me/jamiexaice')],
            [InlineKeyboardButton("Continue to Checkout", url='https://xaijhaven.com/users_area/checkout.php')]
        ]
        reply_markup = InlineKeyboardMarkup(keyboard)
        await query.edit_message_text(text="Payment confirmed. What would you like to do next?" if context.user_data['language'] == 'ru' else "Оплата подтверждена. Что вы хотите сделать дальше?", reply_markup=reply_markup)
        await send_order_details(context)
        return -1
    elif query.data == 'cancel':
        await query.edit_message_text(text="Payment canceled. Please start again." if context.user_data['language'] == 'ru' else "Оплата отменена. Пожалуйста, начните сначала.")
        return -1

# Function to send order details to merchant
async def send_order_details(context: ContextTypes.DEFAULT_TYPE) -> None:
    try:
        user_data = context.user_data
        order_details = f"""
Customer Telegram Contact: {user_data['customer_telegram']}

Order Details:

Country: {user_data['country']}
Payment Method: {user_data['payment_method']}
"""
        await context.bot.send_message(chat_id="@jamiexaice", text=order_details)
        logger.info("Order details sent to the merchant successfully.")
    except Exception as e:
        logger.error(f"Error sending message to the merchant: {e}")

async def main() -> None:
    # Create the Application and pass it your bot's token.
    application = ApplicationBuilder().token(BOT_TOKEN).build()

    # Get the dispatcher to register handlers
    application.add_handler(CommandHandler("start", start))
    application.add_handler(CallbackQueryHandler(button))

    # Start the Bot
    await application.initialize()
    await application.start()
    await application.updater.start_polling()

if __name__ == '__main__':
    asyncio.run(main())

