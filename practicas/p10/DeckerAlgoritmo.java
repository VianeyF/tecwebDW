public class DeckerAlgoritmo{
    private static volatile boolean [] wantsToEnter={false, false};
    private static volatile int turn=0;
    private static void main (Striung[] args){
        Thread process0=new Thread(new Process(0));
        Thread process1=new Thread(new Process(1));
        process0.start();
        process1.start();
    }
    static class Process implements Runnable{
        private int id;
        public Process (int id){
            this.id=id;
        }
    }
    @Override
    public void run(){
        for(int=0; i<5, i++){
            wantsToEnter[id]=true;
            while(wantsToEnter[1-id]){
                if(turn!=id){
                    wantsToEnter[id]=false;
                    while(turn!=id){
                        wantsToEnter[id]=true;
                    }
                }
            }
        }
    }
    System

}