
#import "ViewController.h"
#import "AddViewController.h"
#import "ContactModel.h"
#import "AppDelegate.h"
#import "Person+CoreDataProperties.h"
@interface ViewController ()<AddViewControllerDelegate,UITableViewDataSource,UITableViewDelegate>
@property (strong, nonatomic) IBOutlet UITableView *tableView;
@property (nonatomic,strong) NSMutableArray *dataSource;
@property (nonatomic,strong)AppDelegate *myAppDelegate;
@end

@implementation ViewController

- (void)viewDidLoad {
    [super viewDidLoad];
     self.myAppDelegate = [UIApplication sharedApplication].delegate;
     self.dataSource = [NSMutableArray array];
    NSFetchRequest *request = [[NSFetchRequest alloc]initWithEntityName:@"Person"];
    NSArray *result = [self.myAppDelegate.managedObjectContext executeFetchRequest:request error:nil];
    //给数据源数组添加数据
    [self.dataSource addObjectsFromArray:result];
    
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}





#pragma mark - AddViewController delegate
- (void)addContact:(AddViewController *)addVc didAddContact:(ContactModel *)contact{
    //1.添加数据模型
    [self.dataSource addObject:contact];
    
    //创建实体描述对象
    NSEntityDescription *description = [NSEntityDescription entityForName:@"Person" inManagedObjectContext:self.myAppDelegate.managedObjectContext];
    
    //1.先创建一个模型对象
    Person *aperson = [[Person alloc]initWithEntity:description insertIntoManagedObjectContext:self.myAppDelegate.managedObjectContext];

    [self.dataSource addObject:aperson];
    

    
    
        [self.myAppDelegate saveContext];
    //2.刷新表视图
    [self.tableView reloadData];

}



#pragma mark - tableView的delegate 和 dataSource方法
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return self.dataSource.count;
}

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    return 1;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"cell" forIndexPath:indexPath];
    

    ContactModel *contactModel = self.dataSource[indexPath.row];
   
     cell.textLabel.text = contactModel.name;
 
//   [self.tableView insertRowsAtIndexPaths:@[[NSIndexPath indexPathForRow:self.dataSource.count - 1 inSection:0]] withRowAnimation:UITableViewRowAnimationLeft];
        [self.tableView reloadData];
    
    //创建实体描述对象
    NSEntityDescription *description = [NSEntityDescription entityForName:@"Person" inManagedObjectContext:self.myAppDelegate.managedObjectContext];
   
    //1.先创建一个模型对象
    Person *aperson = [[Person alloc]initWithEntity:description insertIntoManagedObjectContext:self.myAppDelegate.managedObjectContext];
    aperson.name = contactModel.name;
    aperson.phone = contactModel.phone;
    aperson.qq = contactModel.qq;
    [self.dataSource addObject:aperson];

    [self.myAppDelegate saveContext];
    
        return cell;
    
}



#pragma mark - Navigation


- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    AddViewController *contactVc = segue.destinationViewController;
    contactVc.delegate = self;
    
    
   
}








@end
