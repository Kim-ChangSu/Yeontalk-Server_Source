package chatserver;

public class Main {
	
	public static void main(String [] args)
    {
        ChatServer chatServer = new ChatServer(); //create the MainFrame object
        Thread thread  = new Thread(chatServer); //run in a new thread
        thread.start(); //start the thread
    }

}

