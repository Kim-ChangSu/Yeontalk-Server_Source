package chatserver;

import java.io.PrintWriter;

public class ClientWriter {
	
	String mUserId;
	PrintWriter mPrintWriter;
	
	public ClientWriter(String userId, PrintWriter printWriter) {
		mUserId = userId;
		mPrintWriter = printWriter;
	}
	
	public String getUserId() {
        return mUserId;
    }

    public PrintWriter getPrintWriter() {
        return mPrintWriter;
    }
	
	

	

}

