import openai

def chat_with_ai(prompt, model="gpt-4"):  # Use "gpt-3.5-turbo" for a cheaper alternative
    try:
        response = openai.ChatCompletion.create(
            model=model,
            messages=[{"role": "system", "content": "You are a helpful AI assistant."},
                      {"role": "user", "content": prompt}]
        )
        return response["choices"][0]["message"]["content"]
    except Exception as e:
        return f"Error: {str(e)}"

def main():
    print("AI Q&A Chatbot. Type 'exit' to quit.")
    while True:
        user_input = input("You: ")
        if user_input.lower() == "exit":
            print("Goodbye!")
            break
        answer = chat_with_ai(user_input)
        print(f"AI: {answer}")

if __name__ == "__main__":
    main()
        