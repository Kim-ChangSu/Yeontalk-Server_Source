package chatserver;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.BindException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

public class ChatServer implements Runnable {
	
	private ServerSocket server;
	private Socket client;
	private final int portNumber = 7777;
	private BufferedWriter out;
	private BufferedReader in;
	private String localUsername;
	private String remoteUsername;

	@Override
	public void run() {
		// TODO Auto-generated method stub
		try
        {
            server = new ServerSocket(portNumber);//create the socket object
            System.out.println("ChatServer Running");
 
            while (true) {
            	Socket socket = server.accept();
            	System.out.println("Client");
            	Thread thread = new EachClientThread(socket);
            	thread.start();
            }
            
        }
        catch(BindException e1)
        {
        	System.out.println("server error!" + e1.toString());
        }
        catch(Exception e)
        {
            System.out.println("server error!" + e.toString());
        }
		
	}

}

class EachClientThread extends Thread {
	
	static List<ClientWriter> list = Collections.synchronizedList(new ArrayList<ClientWriter>());
	ClientWriter clientWriter;
	Socket socket;
	
	public EachClientThread(Socket socket) {
		this.socket = socket;
	}
	
	@Override
	public void run() {

		String userID =null;
		Boolean listAdded;

		try {

			PrintWriter writer = new PrintWriter(socket.getOutputStream()); 
			BufferedReader reader = new BufferedReader(new InputStreamReader(socket.getInputStream()));

			userID = reader.readLine();
			System.out.println("userId : " + userID);

			list.remove(clientWriter);

			int x = -1;

			for (int i = 0; i < list.size(); i++) {
			
				if(list.get(i).getUserId().equals(userID)) {
					x = i;
				}
			}

			if (x != -1) {
				list.remove(x);
			}

			System.out.println("Chat Users");
			
    		for (int i = 0; i < list.size(); i++) {

				System.out.print(list.get(i).getUserId() + " / ");
					
			}

			if (userID != null) {
				clientWriter = new ClientWriter(userID, writer);
	    		list.add(clientWriter);

	    		System.out.println("Chat Users");
	    		for (int i = 0; i < list.size(); i++) {

					System.out.print(list.get(i).getUserId() + " / ");
						
				}
				System.out.println("");
				
				while(true) {

					String message = reader.readLine();
					String[] message_split = message.split(">", 2);
					
					System.out.println("message : " + message);

			        String toUserId = message_split[0];

			        System.out.println("send to : " + toUserId);
			       
					if(message == null) {

						break;

					} else {
						send(toUserId, message);
					}
					
				}
			} else {

			}
	        	
		} catch (Exception e) {
			System.out.println(e.getMessage());
		} finally {
			
			try {	

				socket.close();			

			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}

		}
	}

	private void send(String toUserId, String message) {
		
		for (ClientWriter writer : list) {
			
			if(writer.getUserId().equals(toUserId)) {
				System.out.println("send to: " + writer.getUserId());
				
				writer.getPrintWriter().println(message);
				writer.getPrintWriter().flush();
			}
			
		}
	}
		
}

